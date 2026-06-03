<script setup>
import { computed, ref } from 'vue';
import { Button } from '@/components/ui/button';

const props = defineProps({
    slides: {
        type: Array,
        default: () => [],
    },
});

const index = ref(0);
const audioRef = ref(null);
const hasStartedAudio = ref(false);

const currentSlide = computed(() => {
    if (!props.slides.length) {
        return null;
    }

    return props.slides[index.value] ?? null;
});

const next = () => {
    if (!props.slides.length) {
        return;
    }

    if (!hasStartedAudio.value && audioRef.value) {
        hasStartedAudio.value = true;
        audioRef.value.play().catch(() => {});
    }

    index.value = (index.value + 1) % props.slides.length;
};

const previous = () => {
    if (!props.slides.length) {
        return;
    }

    index.value = (index.value - 1 + props.slides.length) % props.slides.length;
};
</script>

<template>
    <div class="relative min-h-screen w-full overflow-hidden bg-neutral-950 text-neutral-100">
        <div
            class="pointer-events-none absolute inset-0 bg-[url('/background.jpg')] bg-cover bg-center opacity-25"
        ></div>
        <div class="relative flex min-h-screen items-center justify-center px-4 py-8">
            <div class="flex w-[90vw] max-w-[1200px] flex-col items-center gap-5">
                <div class="w-full">
                    <img
                        v-if="currentSlide"
                        :src="currentSlide"
                        class="max-h-[70vh] w-full rounded-md object-contain shadow-[0_0_0_1px_rgba(255,255,255,0.06)]"
                        alt="Slide"
                    />
                    <div
                        v-else
                        class="flex aspect-[4/3] w-full items-center justify-center rounded-md border border-neutral-800 bg-neutral-900/40 text-sm text-neutral-400"
                    >
                        Nenhuma imagem encontrada em public/assets/slides
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <Button variant="secondary" @click="previous">Anterior</Button>
                    <Button @click="next">Próximo</Button>
                </div>
            </div>
        </div>
        <audio ref="audioRef" src="/music.mp3" loop preload="none"></audio>
    </div>
</template>
