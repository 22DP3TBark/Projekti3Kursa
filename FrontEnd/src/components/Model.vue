<script setup>
defineProps(['close'])
</script>

<template>
    <div class="modal-overlay" @click.self="close">
        <div class="modal-content">
            <slot/>
        </div>

    </div>

</template>


<style scoped>
.modal-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100vw;
  height: 100vh;
  background-color: rgba(0, 0, 0, 0.5);
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 999;
}
.modal-content {
  background-color: white;
  padding: 2rem;
  border-radius: 12px;
  min-width: 300px;
  max-width: 90%;
  max-height: 90vh;
  overflow-y: auto;
}

</style>