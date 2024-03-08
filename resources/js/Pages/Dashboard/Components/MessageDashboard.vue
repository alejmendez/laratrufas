<script setup>
import { useI18n } from 'vue-i18n'

const props = defineProps({
  tasks: Array,
})

const { t } = useI18n()
const messages = [
  {
    id: 1,
    img: 'https://i.pravatar.cc/35?img=1',
    text: 'Riego con fertilizantes cambió de estado a terminado',
    dateRelative: 'Hoy',
  },
  {
    id: 2,
    img: 'https://i.pravatar.cc/35?img=1',
    text: 'Riego con fertilizantes cambió de estado a terminado',
    dateRelative: '23/02/24',
  },
  {
    id: 3,
    img: 'https://i.pravatar.cc/35?img=2',
    text: 'Tarea de insumos esta vencida',
    dateRelative: '23/02/24',
  },
  {
    id: 4,
    img: 'https://i.pravatar.cc/35?img=3',
    text: 'Tarea de insumos esta vencida',
    dateRelative: '23/02/24',
  },
  {
    id: 5,
    img: 'https://i.pravatar.cc/35?img=4',
    text: 'Riego con fertilizantes cambió de estado a terminado',
    dateRelative: '20/02/24',
  },
  {
    id: 6,
    img: 'https://i.pravatar.cc/35?img=5',
    text: 'Riego con fertilizantes cambió de estado a terminado',
    dateRelative: '20/02/24',
  },
  {
    id: 7,
    img: 'https://i.pravatar.cc/35?img=6',
    text: 'Riego con fertilizantes cambió de estado a terminado',
    dateRelative: '20/02/24',
  },
]
</script>

<template>
  <div class="p-5 rounded-xl bg-white shadow-sm border border-gray-200">
    <h5 class="text-gray-500 font-bold">Mensajes</h5>

    <div class="mt-5" v-for="message in messages" :key="message.id">
      <img class="w-[35px] rounded-full border-2 border-gray-50 float-left me-2" :src="message.img" alt="" />
      <div>
        <span class="text-gray-500 font-bold text-[12px] float-right">{{ message.dateRelative }}</span>
        {{ message.text }}
      </div>
    </div>
  </div>
</template>
