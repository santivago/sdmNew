<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import DangerButton from '@/Components/DangerButton.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import WarningButton from '@/Components/WarningButton.vue';
import SelectInput from '@/Components/SelectInput.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import Modal from '@/Components/Modal.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { nextTick, ref } from 'vue';
import Swal from 'sweetalert2'
import VueTailwindPagination from '@ocrv/vue-tailwind-pagination'

const nameInput =ref(null);
const modal = ref(false);
const title = ref('');
const operation = ref(1);
const id = ref('');
const rolSelected = ref([1]);

const props = defineProps({
    users:{type:Object},
    roles:{type:Object}
});
const form = useForm({
    name:'',email:'',rolSelected
})

const formPage=useForm({});
const onPageClick = (event)=>{
    formPage.get(route('users.index',{page:event}))
}
const openModal= (op,name,email,roles,user)=>{
    modal.value=true;
    nextTick(()=>nameInput.value.focus());
    operation.value=op;
    id.value= user;
    if (op==1) {
        title.value='Create Course'
    }else{
        title.value='Edit Course';
        form.name=name;
        form.email=email;
        form.roles=roles;
    }
}
const ok = (msj) =>{
    form.reset();
    closeModal();
    Swal.fire({title:msj,icon:'success'})
}
const closeModal =()=>{
    modal.value= false;
    form.reset()
}
const save = () =>{
    if (operation.value==1) {
        form.post(route('users.store'),{
            onSuccess: () => { ok('Course created')}
        });    
    }else{
        form.put(route('users.update',id.value),{
            onSuccess: () => { ok('userrrrr update')}
        });    
    }
}

const deleteUser = (id,name) =>{
    const alerta = Swal.mixin({
        buttonsStyling:true
    })
    alerta.fire({
        title:'Sicuro che vuo eliminare' + name + '?',
        icon:'question', showCancelButton:true,
        confirmButtonText:'<i class="fa-solid fa-check"></i> Si,eliminare',
        cancelButtonText:'<i class="fa-solid fa-ban"></i> Cancelare'
    }).then((result)=>{
        if(result.isConfirmed){
            form.delete(route('users.destroy',id),{
                onSuccess: () => {ok('UserEliminated')}
            });
        }
    });
}


</script>

<template>
    <Head title="Courses" />
{{ roles }}
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Users</h2>
        </template>

        <div class="py-12">
            <div class="bg-white grid v-screen place-items-center">
                <div class="mt-3 mb-3 flex">
                    <PrimaryButton @click="$event => openModal(1)" >
                        <i class="fa-solid fa-plus-circle"></i> Add
                    </PrimaryButton>
                    <!-- <Link :href="route('courses.create')"
                    :class="'px-4 py-2 bg-gray-800 text-white border rounded-md font-semibold text-xs'">
                    <i class="fa-solid fa-plus-circle"></i> Add  -->
                <!-- </Link> -->
                </div>
            </div>
            <div class="bg-white grid v-screen place-items-center overflow-x-auto">
                <table class="table-auto border border-gray-400">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="px-2 py-2">#</th>
                            <th class="px-2 py-2">User</th>
                            <th class="px-2 py-2">Email</th>
                            <th class="px-2 py-2">#</th>
                            <th class="px-2 py-2">#</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="use, i in users" :key="use.id">
                            <td class="border border-gray-400 px-2 py-2">{{ (i+1) }}</td>
                            <td class="border border-gray-400 px-2 py-2">{{ use.name }}</td>
                            <td class="border border-gray-400 px-2 py-2">{{ use.email }}</td>
                            <td class="border border-gray-400 px-2 py-2">
                                <WarningButton @click="openModal(2,use.name,use.email,use.roles,use.id)">
                                    <i class="fa-solid fa-edit"></i>
                                </WarningButton>
                                <!-- <Link :href="route('courses.edit', cou.id)"
                    :class="'px-4 py-2 bg-yellow-400 text-white border rounded-md font-semibold text-xs'">
                    <i class="fa-solid fa-edit"></i> -->
                <!-- </Link> -->
                            </td>
                            <td class="border border-gray-400 px-2 py-2">
                                <DangerButton @click="$event=> deleteUser(use.id,use.name)">
                                    <i class="fa-solid fa-trash"></i>
                                </DangerButton>
                                
                            </td>
                        </tr>
                    </tbody>
                </table>

            </div>
        </div>
        <Modal :show="modal" @close="closeModal">
            <h2 class="p-3 text-lg font.medium text-hray-900">{{ title }}</h2>
            <div class="p-3">
                <InputLabel for="name" value="Name:"></InputLabel>
                <TextInput id="name" ref="nameInput" v-model="form.name" type="text" class="mt-1 block w-3/4" placeholder="Name" ></TextInput>
                <InputError :message="form.errors.name" class="mt-2"></InputError>
            </div>
            <div class="p-3">
                <InputLabel for="email" value="Email:"></InputLabel>
                <TextInput id="email"   v-model="form.email" type="text" class="mt-1 block w-3/4" placeholder="Email" ></TextInput>
                <InputError :message="form.errors.email" class="mt-2"></InputError>
            </div>
            <div class="p-3">
                <li v-for="role in roles">
                
                <label>
                    <input type="checkbox" v-model="rolSelected " :value="role.id" >{{ role.name }}</label><br />
                </li>
                
            </div>
            <!-- <div class="p-3">
                <InputLabel for="course_id" value="Course:"></InputLabel>
                <SelectInput id="course_id" :options="courses"  v-model="form.course_id" type="text" class="mt-1 block w-3/4"  ></SelectInput>
                <InputError :message="form.errors.course_id" class="mt-2"></InputError>
            </div> -->
            <div class="p-3 mt-6">
                <PrimaryButton :disable="form.processing" @click="save">
                    <i class="fa-solid fa-save">Save</i>
                </PrimaryButton>
            </div>
           {{ rolSelected }}
            <div class="p-3 mt-6 flex justify-end">
                <SecondaryButton class="ml-3" :disabled="form.processing" @click="closeModal">Cancel</SecondaryButton>
            </div>
        </Modal>
    </AuthenticatedLayout>
</template>
