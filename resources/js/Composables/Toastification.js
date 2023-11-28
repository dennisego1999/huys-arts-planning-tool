import Toastification from '@/Components/Toastification.vue';
import { useToast } from 'vue-toastification';
import { nextTick } from 'vue';

// Create toast instance
const toastPopup = useToast();

async function useShowToast(title, text, type, options) {
	// Set toast content and set default values
	const content = {
		component: Toastification,
		props: {
			title: title ? title : '',
			text: text ? text : ''
		},
		listeners: {
			click: () => options?.onClick ?? null
		}
	};

	await nextTick();

	if (type === 'error') {
		return toastPopup.error(content, options);
	}

	if (type === 'warning') {
		return toastPopup.warning(content, options);
	}

	if (type === 'info') {
		return toastPopup.info(content, options);
	}

	if (type === 'success') {
		return toastPopup.success(content, options);
	}

	return toastPopup(content, options);
}

async function useClearToast(id) {
	await nextTick();
	toastPopup.dismiss(id);
}

async function useClearToasts() {
	await nextTick();
	toastPopup.clear();
}

export { useShowToast, useClearToast, useClearToasts };
