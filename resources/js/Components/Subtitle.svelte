<script lang="ts">
    import type { Snippet } from 'svelte';
    import type { HTMLLabelAttributes } from 'svelte/elements';

    let {
        class: className,
        children,
        value,
        ...attrs
    }: HTMLLabelAttributes & {
        children?: Snippet;
        value?: string;
    } = $props();
</script>

<div>
    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400 {className}">
        <slot />
    </p>
</div>
