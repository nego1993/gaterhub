<!-- resources/js/Pages/MenuCreate.vue -->
<script setup>
import MenuSidebar from '@/Layouts/MenuSidebar.vue';
import { Head, usePage } from '@inertiajs/vue3';
import { ref, reactive, watch } from 'vue';
import { useForm } from '@inertiajs/vue3';
import AuthenticatedGerenciador from '@/Layouts/Gerenciador/AuthenticatedGerenciador.vue';

const props = defineProps({
    menus: {
        type: Array,
        default: () => [],
    },
});

// Tornamos os menus reativos
const localMenus = reactive([...props.menus]);

const showCreateModal = ref(false);
const showEditModal = ref(false);

const form = useForm({
    id: null,
    nm_menu: '',
    nm_link: '',
    sg_icon: '',
    ic_ativo: 1,
    ic_raiz: 0,
    ic_parent: ''
});

// Sincroniza os menus do props com localMenus quando props mudar
watch(() => props.menus, (newMenus) => {
    localMenus.splice(0, localMenus.length, ...newMenus);
}, { deep: true });

const openCreateModal = () => {
    form.reset();
    form.clearErrors();
    showCreateModal.value = true;
};

const openEditModal = (menu) => {
    form.reset();
    form.clearErrors();
    form.id = menu.id;
    form.nm_menu = menu.nm_menu;
    form.nm_link = menu.nm_link;
    form.sg_icon = menu.sg_icon || '';
    form.ic_ativo = Number(menu.ic_ativo);
    form.ic_raiz = Number(menu.ic_raiz);
    form.ic_parent = menu.ic_parent;
    showEditModal.value = true;
};

const closeModal = () => {
    showCreateModal.value = false;
    showEditModal.value = false;
};

const submit = () => {
    if (form.id) {
        form.put(route('menu.update', form.id), {
            onSuccess: () => {
                // Atualiza o menu localmente
                const index = localMenus.findIndex(menu => menu.id === form.id);
                if (index !== -1) {
                    localMenus[index] = {
                        ...localMenus[index],
                        nm_menu: form.nm_menu,
                        nm_link: form.nm_link,
                        sg_icon: form.sg_icon,
                        ic_ativo: form.ic_ativo,
                        ic_raiz: form.ic_raiz,
                        ic_parent: form.ic_parent,
                    };
                }
                closeModal();
                window.location.reload();
            },
            onError: (errors) => {
                console.error('Erro ao atualizar menu:', errors);
            },
        });
    } else {
        form.post(route('menu.store'), {
            onSuccess: () => {
                localMenus.push({
                    id: form.id, // O backend deve retornar o ID
                    nm_menu: form.nm_menu,
                    nm_link: form.nm_link,
                    sg_icon: form.sg_icon,
                    ic_ativo: form.ic_ativo,
                    ic_raiz: form.ic_raiz,
                    ic_parent: form.ic_parent,
                });
                form.reset();
                closeModal();
                window.location.reload();
            },
            onError: (errors) => {
                console.error('Erro ao criar menu:', errors);
            },
        });
    }
};
</script>

<template>

    <Head title="Gerenciador - menu" />
    <AuthenticatedGerenciador>
        <MenuSidebar :menus="menus">
            <template #header>
                <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                    Menus
                </h2>
                <button @click="openCreateModal"
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Criar novo menu
                </button>
            </template>

            <div class="flex flex-col mt-8">
                <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                        <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                            <table class="min-w-full divide-y divide-gray-200 table-striped">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Nome
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Link
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Status
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Ações
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <tr v-for="menu in menus" :key="menu.id">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-10 w-10">
                                                    <i :class="menu.sg_icon" class="text-2xl"></i>
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900">
                                                        {{ menu.nm_menu }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ menu.nm_link }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span v-if="menu.ic_ativo"
                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                    stroke-width="1.5" stroke="currentColor"
                                                    class="it-dynamic-icon it-badge-icon me-1 size-4">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="m4.5 12.75 6 6 9-13.5">
                                                    </path>
                                                </svg>
                                                Ativo
                                            </span>
                                            <span v-else
                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                    stroke-width="1.5" stroke="currentColor"
                                                    class="it-dynamic-icon it-badge-icon me-1 size-4">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M18.364 18.364A9 9 0 0 0 5.636 5.636m12.728 12.728A9 9 0 0 1 5.636 5.636m12.728 12.728L5.636 5.636">
                                                    </path>
                                                </svg>
                                                Inativo
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <button @click="openEditModal(menu)"
                                                class="text-indigo-600 hover:text-indigo-900"><i class="fa fa-edit"></i> Editar</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Create Modal -->
            <div v-if="showCreateModal"
                class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center z-50">
                <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Criar Novo Menu</h3>
                    <form @submit.prevent="submit" class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Nome do Menu</label>
                            <input v-model="form.nm_menu" type="text"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Link</label>
                            <input v-model="form.nm_link" type="text"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Ícone (Font Awesome)</label>
                            <input v-model="form.sg_icon" type="text"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                                placeholder="ex: fas fa-tachometer-alt" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Ativo</label>
                            <select v-model="form.ic_ativo"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                <option :value="1">Sim</option>
                                <option :value="0">Não</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Menu Raiz</label>
                            <select v-model="form.ic_raiz"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                <option :value="1">Sim</option>
                                <option :value="0">Não</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Menu Pai</label>
                            <select v-model="form.ic_parent"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                <option value="">Nenhum</option>
                                <option v-for="menu in menus" :key="menu.id" :value="menu.id">{{ menu.nm_menu }}</option>
                            </select>
                        </div>

                        <div class="flex justify-end space-x-2">
                            <button type="button" @click="closeModal"
                                class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                Cancelar
                            </button>
                            <button type="submit"
                                class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                Salvar
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Edit Modal -->
            <div v-if="showEditModal"
                class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center z-50">
                <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Editar Menu</h3>
                    <form @submit.prevent="submit" class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Nome do Menu</label>
                            <input v-model="form.nm_menu" type="text"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Link</label>
                            <input v-model="form.nm_link" type="text"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Ícone (Font Awesome)</label>
                            <input v-model="form.sg_icon" type="text"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                                placeholder="ex: fas fa-tachometer-alt" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Ativo</label>
                            <select v-model="form.ic_ativo"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                <option :value="1">Sim</option>
                                <option :value="0">Não</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Menu Raiz</label>
                            <select v-model="form.ic_raiz"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                <option :value="1">Sim</option>
                                <option :value="0">Não</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Menu Pai</label>
                            <select v-model="form.ic_parent"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                <option value="" v-if="form.ic_parent == null">Nenhum</option>
                                <option v-for="menu in menus" :key="menu.id" :value="menu.id">{{ menu.nm_menu }}</option>
                            </select>
                        </div>
                        <div class="flex justify-end space-x-2">
                            <button type="button" @click="closeModal"
                                class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                Cancelar
                            </button>
                            <button type="submit"
                                class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                Salvar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </MenuSidebar>
    </AuthenticatedGerenciador>
</template>