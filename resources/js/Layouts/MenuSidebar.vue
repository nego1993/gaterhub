<!-- MenuSidebar.vue -->
<script setup>
import { onMounted, ref } from 'vue';
import { Link } from '@inertiajs/vue3';

const isSidebarOpen = ref(true);
const menus = ref([]);
const openDropdown = ref(null);

const toggleSidebar = () => {
    isSidebarOpen.value = !isSidebarOpen.value;
};

const toggleDropdown = (menuId) => {
    openDropdown.value = openDropdown.value === menuId ? null : menuId;
};

const buscaMenus = async () => {
    try {
        const response = await fetch(route('api.menu.index'));
        const data = await response.json();
        menus.value = data;
    } catch (error) {
        console.error('Erro ao buscar menus:', error);
    }
};

onMounted(() => {
    buscaMenus();
});
</script>

<template>
    <div class="min-h-screen flex flex-col">
        <div class="flex flex-1">
            <!-- Sidebar -->
            <aside :class="[
                'bg-gray-800 text-white w-64 space-y-6 py-7 px-2 fixed inset-y-0 left-0 transform',
                isSidebarOpen ? 'translate-x-0' : '-translate-x-full',
                'md:relative md:translate-x-0 transition duration-200 ease-in-out z-30'
            ]">
                <nav>
                    <template v-for="menu in menus.filter(m => m.ic_ativo)" :key="menu.id">
                        <!-- Item normal -->
                        <Link v-if="menu.ic_raiz !== 1" :href="menu.nm_link"
                            class="flex items-center space-x-2 px-4 py-2 text-sm font-medium rounded-md hover:bg-gray-700">
                            <i v-if="menu.sg_icon" :class="menu.sg_icon" class="h-6 w-6 flex items-center"></i>
                            <span>{{ menu.nm_menu }}</span>
                        </Link>

                        <!-- Dropdown para ic_raiz === 1 -->
                        <div v-else class="relative">
                            <button @click="toggleDropdown(menu.id)"
                                class="flex items-center w-full space-x-2 px-4 py-2 text-sm font-medium rounded-md hover:bg-gray-700">
                                <i v-if="menu.sg_icon" :class="menu.sg_icon" class="h-6 w-6 flex items-center"></i>
                                <span>{{ menu.nm_menu }}</span>
                                <svg class="h-4 w-4 ml-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                            <!-- Itens do dropdown -->
                            <div v-if="openDropdown === menu.id"
                                class="mt-1 bg-gray-700 rounded-md shadow-lg">
                                <Link v-for="subItem in menu.subItems" :key="subItem.id" :href="subItem.nm_link"
                                    class="block px-4 py-2 text-sm text-white hover:bg-gray-600">
                                    {{ subItem.nm_menu }}
                                </Link>
                            </div>
                        </div>
                    </template>
                </nav>
            </aside>

            <!-- Main content -->
            <div class="flex-1 flex flex-col">
                <!-- Header -->
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 flex justify-between">
                        <button @click="toggleSidebar" class="md:hidden focus:outline-none">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>
                        <slot name="header" />
                    </div>
                </header>

                <!-- Page content -->
                <main class="flex-1 bg-gray-100">
                    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
                        <slot />
                    </div>
                </main>
            </div>
        </div>
    </div>
</template>