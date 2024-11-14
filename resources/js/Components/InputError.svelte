<script lang="ts">
    import type { HTMLAttributes } from 'svelte/elements';

    let {
        message,
        ...attrs
    }: HTMLAttributes<HTMLDivElement> & {
        message?: string
    } = $props()
</script>

{#if message}
    <div {...attrs}>
        <p class="text-sm text-red-600">
            {message}
        </p>
    </div>
{/if}
