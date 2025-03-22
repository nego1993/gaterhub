<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import MenuSidebar from '@/Layouts/MenuSidebar.vue';
import { Head } from '@inertiajs/vue3';
import AuthenticatedGerenciador from '@/Layouts/Gerenciador/AuthenticatedGerenciador.vue';
</script>

<template>
    <AuthenticatedGerenciador>

        <MenuSidebar>

            <Head title="Gerenciador" />
            <template #header>
                <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                    Gerenciador
                </h2>
            </template>

        </MenuSidebar>
    </AuthenticatedGerenciador>


</template>