<script setup>
import VEditor from '@/Components/Form/VEditor.vue';

const props = defineProps({
  t: Function,
  form: Object,
  responsibles: Array,
});

const t = props.t;
const form = props.form;
</script>

<template>
  <CardSection :header-text="t('task.sections.comments')" wrapperClass="">
    <VEditor
      id="comments"
      v-model="form.comments"
      :options="responsibles"
      editorStyle="height: 220px"
    />
  </CardSection>
  <div class="h-[220px]"></div>
</template>
