<script lang="ts">
    import { onMount } from 'svelte';
    import type { HTMLInputAttributes } from 'svelte/elements';

    let {
        class: className,
        value = $bindable(),
        ...attrs
    }: HTMLInputAttributes & {
        value?: string
    } = $props()

    let input: HTMLInputElement;

    export function focus() {
        input?.focus()
    }

    onMount(() => {
        if (attrs.autofocus && input) {
            input.focus()
        }
    })
</script>

<input
    {...attrs}
    class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 {className}"
    bind:value
    bind:this={input}
/>
