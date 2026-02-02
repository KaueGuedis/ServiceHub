<template>
  <div>
    <h1 class="text-2xl font-bold mb-4">Criar Ticket</h1>
    <form @submit.prevent="submit">
      <div class="mb-4">
        <label class="block mb-1">Título</label>
        <input v-model="form.title" type="text" class="border rounded w-full p-2" required />
      </div>
      <div class="mb-4">
        <label class="block mb-1">Descrição</label>
        <textarea v-model="form.description" class="border rounded w-full p-2" required></textarea>
      </div>
      <div class="mb-4">
        <label class="block mb-1">Projeto</label>
        <select v-model="form.project_id" class="border rounded w-full p-2" required>
          <option v-for="project in projects" :key="project.id" :value="project.id">
            {{ project.name }}
          </option>
        </select>
      </div>
      <div class="mb-4">
        <label class="block mb-1">Anexo (JSON ou texto, opcional)</label>
        <input type="file" @change="handleFile" class="border rounded w-full p-2" />
      </div>
      <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Criar Ticket</button>
    </form>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import { useForm, usePage } from '@inertiajs/vue3';

const { projects } = defineProps({ projects: Array });
const form = useForm({
  title: '',
  description: '',
  project_id: '',
  attachment: null,
});

function handleFile(e) {
  form.attachment = e.target.files[0];
}

function submit() {
  form.post(route('tickets.store'), {
    forceFormData: true,
  });
}
</script>
