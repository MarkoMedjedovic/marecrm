<script setup>
import { router } from "@inertiajs/vue3";

defineProps({
    id: String,
    blog: Object,
});

const deleteConfirm = (id) => {
    router.delete(`/inertia/${id}`, {
        onBefore: () => confirm("Are you sure you want to delete？"),
    });
};
</script>

<template>
    {{ blog.id }} <br />
    {{ blog.title }}<br />
    <button @click="deleteConfirm(blog.id)">Delete</button>
</template>
