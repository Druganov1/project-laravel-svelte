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
    <h2
        class="text-lg font-medium text-gray-900 dark:text-gray-100 {className}"
    >
        <slot />
    </h2>
</div>
