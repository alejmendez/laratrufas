<script setup>
import { ref, onMounted } from 'vue';
import { useI18n } from 'vue-i18n';
import { fabric } from "fabric";

import { Button } from '@/Components/ui/button';

const { t } = useI18n();

const props = defineProps({
});

let canvas;
let canvasEle = ref(null);
let canvasWrapper = ref(null);
let elementList = ref([]);
let seq = ref(0);

onMounted(() => {
  const width = canvasWrapper.value.offsetWidth;
  const height = Math.round(width / (16 / 9));
  canvas = new fabric.Canvas('canvas', {
    width,
    height,
  });
  fabric.Image.fromURL(`https://placehold.co/${width}x${height}`, (myImg) => {
    const img = myImg.set({
      left: 0,
      top: 0,
      selectable: false,
      hasBorders: false,
      hasControls: false,
      evented: false,
    });
    canvas.add(img);
  });
});

const changeFileHandler = (e) => {
  const imgNode = new Image();
  imgNode.src = URL.createObjectURL(e.fileInput);
  imgNode.onload = () => {
    const imageScale = Math.round((900 / imgNode.width) * 100) / 100;
    const img = new fabric.Image(imgNode, {
      left: 0,
      top: 0,
      selectable: false,
      hasBorders: false,
      hasControls: false,
      evented: false,
    }).scale(imageScale);

    canvas.add(img);

    var rect = new fabric.Rect({
      left: 100,
      top: 50,
      fill: '#0F172A',
      width: 200,
      height: 100,
      objectCaching: false,
      stroke: 'lightgreen',
      strokeWidth: 2,
      borderColor: '#0F172A',
      cornerStyle2: true
    });

    canvas.add(rect);
    canvas.setActiveObject(rect);
  };
};

const attr_base = {
  left: 100,
  top: 50,
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
    width: 200,
    height: 100,
  });
  addElement(ele, 'rectangle');
}

const addCircle = () => {
  const ele = new fabric.Circle({
    ...attr_base,
    id: `circle_${getSeq()}`,
    radius: 75,
  });
  addElement(ele, 'circle');
}

const addPolygon = () => {
  const ele = new fabric.Polygon({
    ...attr_base,
    id: `polygon_${getSeq()}`,
  });
  addElement(ele, 'polygon');
}

const addElement = (ele, type) => {
  canvas.add(ele);
  canvas.setActiveObject(ele);
  elementList.value.push({
    id: ele.id,
    type,
  });
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
    <Button variant="outline" class="mt-3" @click.prevent="addRectangle">
      Agregar Rectangulo
    </Button>

    <Button variant="outline" class="mt-3 ms-3" @click.prevent="addCircle">
      Agregar Circulo
    </Button>

    <Button variant="outline" class="mt-3 ms-3" @click.prevent="addPolygon">
      Agregar poligono
    </Button>
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
