<template>
    <div>
        
        <form @submit.prevent="editarNota(nota)" v-if="editar" class="my-2">
            <h4>Editar tareas</h4>
            <input type="text" class="form-control mb-2" 
                placeholder="Nombre de la nota" v-model="nota.nombre">
            <input type="text" class="form-control mb-2" 
                placeholder="Descripción de la nota" v-model="nota.descripcion">
            <button class="btn btn-warning" type="submit">Guardar</button>
            <button class="btn btn-danger" type="submit" 
                @click="cancelarEdicion">Cancelar</button>
        </form>
        <form class="row g-3 my-2" @submit.prevent="agregar" v-else>
            <h4>Registrar tareas</h4>
        <div class="col-auto">
            <label for="input1" class="visually-hidden">Nombre</label>
            <input type="text" v-model="nota.nombre" class="form-control" id="input1" placeholder="Nombre">
        </div>
        <div class="col-auto">
            <label for="input2" class="visually-hidden">Descripcion</label>
            <input type="text" v-model="nota.descripcion"  class="form-control" id="input2" placeholder="Descripcion">
        </div>
        <div>
            <button type="submit" class="btn btn-primary mb-3">Confirm</button>
        </div>
        </form>
        <div class="accordion-item align-middle">
            <h2 class="accordion-header" id="headingOne">
            <button class="accordion-button text-center" type="button" 
            data-bs-toggle="collapse" data-bs-target="#collapseOne" 
            aria-expanded="true" aria-controls="collapseOne"  @click="mostrarLista()">
                Ver lista de notas
            </button>
            </h2>
            <div id="collapseOne" class="accordion-collapse collapse show" 
                aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                <div class="accordion-body">
                    <ul class="list-group">
                        <!-- <button class="btn btn-success btn-sm" 
                                @click="mostrarLista()">Ver lista de tareas</button> -->
                        <li class="list-group-item" 
                            v-for="(item, index) in notas" :key="index" >
                        
                            <p>{{item.nombre}}</p>
                            <p>{{item.descripcion}}</p>
                            <span class=" badge-primary float-right">
                                {{item.updated_at}}
                            </span>
                            <p>
                                <button class="btn btn-warning btn-sm" 
                                    @click="editarFormulario(item)">Editar</button>
                                <button class="btn btn-danger btn-sm" 
                                    @click="eliminarNota(item, index)">Eliminar</button>
                            </p>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</template>


<script>
export default {
    data() {
        return {
            notas: [],
            nota: {nombre: '', descripcion:''},
            editar: false,
        };
    },
    // created(){
    //     axios.get('/notas').then(res=> this.notas= res.data);
    // },
    methods: {
        agregar(){
            if(this.nota.nombre.trim()==='' || this.nota.descripcion.trim()===''){
                alert('Campos vacios');
                return;
            }
            axios.post('/notas', this.nota)
                .then((res) =>{
                this.notas.push(res.data);
            });
            this.cancelarEdicion();
        },
        mostrarLista(){
            axios.get('/notas').then(res=> this.notas= res.data);
        },
        editarFormulario(item){
            this.nota.nombre = item.nombre;
            this.nota.descripcion = item.descripcion;
            this.nota.id = item.id;
            this.editar = true;
        },
        editarNota(nota){
            axios.put(`/notas/${nota.id}`, this.nota)
                .then(res=>{
                const index = this.notas.findIndex(item => item.id === nota.id);
                this.notas[index] = res.data;
                this.mostrarLista();
            });
            this.cancelarEdicion();
        },
       eliminarNota(item, index){
        const confirmacion = confirm(`Quieres eliminar la nota ${item.nombre}`);
        if(confirmacion){
            axios.delete(`/notas/${item.id}`)
            .then(()=>{
                this.notas.splice(index, 1);
            });
            
        }
        this.cancelarEdicion();
        },
        cancelarEdicion(){
        this.editar = false;
        this.nota.nombre = ''; 
        this.nota.descripcion='';
        },
    }
}
</script>
