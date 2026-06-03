<script setup>
import { cva } from 'class-variance-authority';
import { cn } from '@/lib/utils';

const props = defineProps({
    variant: {
        type: String,
        default: 'default',
    },
    size: {
        type: String,
        default: 'default',
    },
    type: {
        type: String,
        default: 'button',
    },
});

const buttonVariants = cva(
    'inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-neutral-400 disabled:pointer-events-none disabled:opacity-50',
    {
        variants: {
            variant: {
                default: 'bg-neutral-100 text-neutral-950 hover:bg-neutral-200',
                secondary: 'bg-neutral-800 text-neutral-100 hover:bg-neutral-700',
                ghost: 'bg-transparent hover:bg-neutral-900',
                outline:
                    'border border-neutral-800 bg-transparent text-neutral-100 hover:border-neutral-700 hover:bg-neutral-900',
            },
            size: {
                default: 'h-10 px-4',
                sm: 'h-9 rounded-md px-3',
                lg: 'h-11 rounded-md px-8',
            },
        },
        defaultVariants: {
            variant: 'default',
            size: 'default',
        },
    }
);
</script>

<template>
    <button :type="type" :class="cn(buttonVariants({ variant, size }))" v-bind="$attrs">
        <slot />
    </button>
</template>
