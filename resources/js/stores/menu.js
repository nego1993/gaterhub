import { ref } from 'vue';

export const useMenuStore = () => {
    const menus = ref([]);

    const fetchMenus = async () => {
        try {
            const response = await fetch(route('api.menu.index'));
            const data = await response.json();
            menus.value = data;
        } catch (error) {
            console.error(error);
        }
    }

    const updateMenu = (updatedMenu) => {
        const index = menus.value.findIndex(m => m.id === updatedMenu.id);
        if (index !== -1) {
            menus.value[index] = { ...updatedMenu };
        }
    };

    const addMenu = (newMenu) => {
        menus.value.push(newMenu);
    };

    const removeMenu = (menuId) => {
        menus.value = menus.value.filter(m => m.id !== menuId);
    };

    return { menus, fetchMenus, updateMenu, addMenu, removeMenu };
};