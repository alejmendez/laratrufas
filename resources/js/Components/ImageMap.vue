<script setup>
import { ref, reactive, onMounted, watch } from 'vue';
import { useI18n } from 'vue-i18n';
import { fabric } from "fabric";

import { Button } from '@/Components/ui/button';

const { t } = useI18n();

const props = defineProps({
  input: Object,
});

let canvas;
let canvasEle = ref(null);
let canvasWrapper = ref(null);
let elementList = ref([]);
let seq = ref(0);

let polygonCreator = reactive({
  startDrawing: false,
  circleCount: 1,
  polygonCount: 1,
  id: '',
});;

onMounted(() => {
  const width = canvasWrapper.value.offsetWidth;
  const height = Math.round(width / (16 / 9));
  canvas = new fabric.Canvas('canvas', {
    width,
    height,
  });

  // https://stackoverflow.com/questions/48761416/how-to-add-polygon-points-and-draw-it-on-an-image-in-fabric-js

  canvas.on('object:moving', function(option) {
    var object = option.target;
    canvas.getObjects().forEach((o) => {
      if (o.name !== "Polygon" || o.polygon_id !== object.polygon_owner) return;
      const polygon = getShapeById(o.polygon_id);
      const points = poly.get("points");
      points[object.circleNo - 1].x = object.left;
      points[object.circleNo - 1].y = object.top;
      polygon.set({
        points,
      });
    })
    canvas.renderAll();
  });

  canvas.on('mouse:down', function(option) {
    if (!polygonCreator.startDrawing || (option.target && option.target.name == "draggableCircle")) {
      return;
    }

    const pointer = canvas.getPointer(option.e);
    const circle = new fabric.Circle({
      left: pointer.x,
      top: pointer.y,
      radius: 5,
      hasBorders: false,
      hasControls: false,
      name: "draggableCircle",
      polygon_owner: polygonCreator.id,
      circleNo: polygonCreator.circleCount,
      fill: "rgba(0, 0, 0, 0.5)",
      hasRotatingPoint: false,
      originX: 'center',
      originY: 'center'
    });
    canvas.add(circle);
    polygonCreator.circleCount++;
  });
});

watch(() => props.input, (input, prevInput) => {
  removeElement('background');
  const imgNode = new Image();
  imgNode.src = URL.createObjectURL(input);
  imgNode.onload = () => {
    const img = new fabric.Image(imgNode, {
      id: 'background',
      left: 0,
      top: 0,
      selectable: false,
      hasBorders: false,
      hasControls: false,
      evented: false,
    }).scaleToWidth(canvas.width, false);

    canvas.add(img);
  };
});

const attr_base = {
  fill: '#ddd',
  opacity: 0.6,
  stroke: '#0F172A',
  strokeWidth: 1,
  borderColor: '#0F172A',
  cornerStyle: 1,
  cornerColor: '#0F172A',
  cornerFill: 'black',
  cornerSize: 6,
  objectCaching: false,
};

const getSeq = () => {
  const currentValue = seq.value;
  seq.value = currentValue + 1;
  return currentValue;
}

const addRectangle = () => {
  const ele = new fabric.Rect({
    ...attr_base,
    id: `rectangle_${getSeq()}`,
    left: 100,
    top: 50,
    width: 200,
    height: 100,
  });
  addElement(ele, 'rectangle');
}

const addCircle = () => {
  const ele = new fabric.Circle({
    ...attr_base,
    id: `circle_${getSeq()}`,
    left: 100,
    top: 50,
    radius: 75,
  });
  addElement(ele, 'circle');
}

const addPolygon = () => {
  polygonCreator.id = `polygon_${getSeq()}`;
  polygonCreator.startDrawing = true;
  // const ele = new fabric.Polygon({
  //   ...attr_base,
  //   id: `polygon_${getSeq()}`,
  // });
  // addElement(ele, 'polygon');
}

const donePolygon = () => {
  polygonCreator.startDrawing = false;
  polygonCreator.circleCount = 1;

  const points = [];
  console.log(polygonCreator.id)
  canvas.getObjects().forEach((o) => {
    if(o.polygon_owner === polygonCreator.id) {
      points.push({
        x: o.left,
        y: o.top
      });
      canvas.renderAll();
    }
  });
  console.log(points)

  const ele = new fabric.Polygon(points, {
    ...attr_base,
    id: polygonCreator.id,
    polygon_id: polygonCreator.id,
    name: "Polygon",
  });

  canvas.getObjects().forEach((o) => {
    if (o.name === 'draggableCircle') {
      canvas.remove(o);
    }
  });

  addElement(ele, 'polygon');
  canvas.renderAll();
  polygonCreator.polygonCount++;
}

const addImage = () => {
  removeElement('background');
  fabric.Image.fromURL(`https://placehold.co/1280x720`, (myImg) => {
    const img = myImg.set({
      id: 'background',
      left: 0,
      top: 0,
      selectable: false,
      selectable: false,
      hasBorders: false,
      hasControls: false,
      evented: false,
    });
    img.scaleToWidth(canvas.width, false)
    canvas.add(img);
  });
}

const addElement = (ele, type) => {
  canvas.add(ele);
  canvas.setActiveObject(ele);
  elementList.value.push({
    id: ele.id,
    type,
  });
}

const getShapeById = (id) => {
  let obj;
  canvas.getObjects().forEach((o) => {
    if(o.id === id) {
      obj = o;
    }
  });
  return obj;
}

const selectElement = (id) => {
  canvas.getObjects().forEach((o) => {
    if(o.id == id) {
      canvas.setActiveObject(o);
      canvas.requestRenderAll();
    }
  })
}

const removeElement = (id) => {
  canvas.getObjects().forEach((o) => {
    if(o.id == id) {
      canvas.remove(o);
      elementList.value = elementList.value.filter((e) => e.id !== id);
    }
  });
}
</script>

<template>
  <div class="form-text col-span-2 form-text-type">
    <template v-if="!polygonCreator.startDrawing">
      <Button variant="outline" class="mt-3" @click.prevent="addRectangle">
        Agregar Rectangulo
      </Button>

      <Button variant="outline" class="mt-3 ms-3" @click.prevent="addCircle">
        Agregar Circulo
      </Button>

      <Button variant="outline" class="mt-3 ms-3" @click.prevent="addPolygon">
        Agregar poligono
      </Button>

      <Button variant="outline" class="mt-3 ms-3" @click.prevent="addImage">
        Agregar imagen
      </Button>
    </template>

    <template v-else>
      <Button variant="outline" class="mt-3 ms-3" @click.prevent="donePolygon">
        Cerrar poligono
      </Button>
    </template>
  </div>

  <div ref="canvasWrapper">
    <canvas id="canvas" ref="canvasEle" class="border-2"></canvas>
  </div>

  <div>
    <div v-for="ele in elementList">
      <div class="mt-2 py-2 ps-2 rounded bg-gray-200 shadow-sm ring-1 ring-gray-950/5">
        {{ ele.type }}
        <Button variant="outline" class="mt-3 ms-3" @click.prevent="selectElement(ele.id)">
          Select {{ ele.id }}
        </Button>
        <Button variant="destructive" class="mt-3 ms-3" @click.prevent="removeElement(ele.id)">
          <font-awesome-icon :icon="['fas', 'trash-can']" />
        </Button>
      </div>
    </div>
  </div>

</template>
