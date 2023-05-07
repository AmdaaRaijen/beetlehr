<script setup>
import axios from "axios";
import dayjs from "dayjs";
import { ref } from "vue";
import { bool, object } from "vue-types";
import { notify } from "notiwind";
import VDialog from "@/components/VDialog/index.vue";
import VButton from "@/components/VButton/index.vue";
import VSelect from "@/components/VSelect/index.vue";
import VInput from "@/components/VInput/index.vue";
import VBadge from "@/components/VBadge/index.vue";

const props = defineProps({
    openDialog: bool(),
    updateAction: bool().def(false),
    data: object().def({}),
    additional: object().def({}),
});

const emit = defineEmits(["close", "successSubmit"]);

const branchSelectHandle = ref();
const placementSelectHandle = ref();
const isLoading = ref(false);
const formError = ref({});
const form = ref({});

const openForm = () => {
    if (props.updateAction) {
        form.value = Object.assign(form.value, props.data);
        // handlebranch(form.value.branch_id)
    } else {
        form.value = ref({});
    }
};

const closeForm = () => {
    form.value = ref({});
    formError.value = ref({});
};

const submit = async () => {
    const fd = new FormData();
    if (form.value.file != null) {
        fd.append("file", form.value.file, form.value.file.name);
    }

    Object.keys(form.value).forEach((key) => {
        fd.append(key, form.value[key]);
    });

    props.updateAction ? update() : create();
};

const update = async () => {
    isLoading.value = true;
    axios
        .put(route("fingerprint.update", { id: props.data.id }), form.value)
        .then((res) => {
            emit("close");
            emit("successSubmit");
            form.value = ref({});
            notify(
                {
                    type: "success",
                    group: "top",
                    text: res.data.meta.message,
                },
                2500
            );
        })
        .catch((res) => {
            // Handle validation errors
            const result = res.response.data;
            const metaError = res.response.data.meta?.error;
            if (result.hasOwnProperty("errors")) {
                formError.value = ref({});
                Object.keys(result.errors).map((key) => {
                    formError.value[key] = result.errors[key].toString();
                });
                console.log(form.value);
            }

            if (metaError) {
                notify(
                    {
                        type: "error",
                        group: "top",
                        text: metaError,
                    },
                    2500
                );
            } else {
                notify(
                    {
                        type: "error",
                        group: "top",
                        text: result.message,
                    },
                    2500
                );
            }
        })
        .finally(() => (isLoading.value = false));
};

const create = async () => {
    isLoading.value = true;
    const editData = {
        ...form.value,
    };
    const serial_number = `SNI-${editData.serial_number}`;
    const data = {
        ...editData,
        serial_number,
    };

    axios
        .post(route("fingerprint.create"), data)
        .then((res) => {
            emit("close");
            emit("successSubmit");
            form.value = ref({});
            notify(
                {
                    type: "success",
                    group: "top",
                    text: res.data.meta.message,
                },
                2500
            );
        })
        .catch((res) => {
            // Handle validation errors
            const result = res.response.data;
            const metaError = res.response.data.meta?.error;
            if (result.hasOwnProperty("errors")) {
                formError.value = ref({});
                Object.keys(result.errors).map((key) => {
                    formError.value[key] = result.errors[key].toString();
                });
            }

            if (metaError) {
                notify(
                    {
                        type: "error",
                        group: "top",
                        text: metaError,
                    },
                    2500
                );
            } else {
                notify(
                    {
                        type: "error",
                        group: "top",
                        text: result.message,
                    },
                    2500
                );
            }
        })
        .finally(() => (isLoading.value = false));
};
</script>

<template>
    <VDialog
        :showModal="openDialog"
        :title="updateAction ? 'Update Fingerprint' : 'Create Fingerprint'"
        @opened="openForm"
        @closed="closeForm"
        size="xl"
    >
        <template v-slot:close>
            <button
                class="text-slate-400 hover:text-slate-500"
                @click="$emit('close')"
            >
                <div class="sr-only">Close</div>
                <svg class="w-4 h-4 fill-current">
                    <path
                        d="M7.95 6.536l4.242-4.243a1 1 0 111.415 1.414L9.364 7.95l4.243 4.242a1 1 0 11-1.415 1.415L7.95 9.364l-4.243 4.243a1 1 0 01-1.414-1.415L6.536 7.95 2.293 3.707a1 1 0 011.414-1.414L7.95 6.536z"
                    />
                </svg>
            </button>
        </template>
        <template v-slot:content>
            <div class="grid grid-cols-2 gap-3">
                <div class="col-span-2"></div>
                <div class="col-span-2">
                    <VInput
                        placeholder="Insert Name"
                        label="Employee Name"
                        :required="true"
                        v-model="form.name"
                        @update:modelValue="formError.name = ''"
                        class="mt-3"
                    />
                    <VInput
                        placeholder="Insert Serial Number"
                        label="Serial Number"
                        :required="true"
                        v-model="form.serial_number"
                        @update:modelValue="formError.serial_number = ''"
                        class="mt-3"
                    />
                    <VSelect
                        placeholder="Is Active"
                        :required="true"
                        v-model="form.is_active"
                        :options="['Yes', 'No']"
                        label="Select Branch"
                        :errorMessage="formError.branch_id"
                        @update:modelValue="formError.is_active = ''"
                        ref="branchSelectHandle"
                    />

                    <div
                        class="text-xs mt-1"
                        :class="[
                            {
                                'text-rose-500': formError.date,
                            },
                        ]"
                        v-if="formError.date"
                    >
                        {{ formError.date }}
                    </div>
                </div>
            </div>
        </template>
        <template v-slot:footer>
            <div class="flex flex-wrap justify-end space-x-2">
                <VButton
                    label="Cancel"
                    type="default"
                    @click="$emit('close')"
                />
                <VButton
                    :is-loading="isLoading"
                    :label="updateAction ? 'Update' : 'Create'"
                    type="primary"
                    @click="submit"
                />
            </div>
        </template>
    </VDialog>
</template>
