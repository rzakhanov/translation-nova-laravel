<template>
    <div id="self-popup" v-if="this.show" @click.self="close">
        <div class="modal-popup">
            <span class="close" @click="close"> x </span>
            <slot></slot>
        </div>
    </div>
</template>
<style scoped>


#self-popup {
    display: flex;
    background: rgb(30 39 49 / 80%);
    width: 100%;
    height: 100%;
    top: 0;
    left: 0;
    z-index: 10000;
    position: fixed;
    justify-content: center;
    align-items: flex-start;
    -webkit-backdrop-filter: blur(7px);
    backdrop-filter: blur(7px);
    margin:0;
}

.modal-popup {
    min-width: 50px;
    min-height: 50px;
    padding: 10px;
    /*background: #fff;*/
    display: block;
    position: relative;
    margin-top: 87px;
}

.modal-popup .close {
    position: absolute;
    top: -43px;
    right: -37px;
    cursor: pointer;
    color: #fff;
    border: 1px solid #fff;
    border-radius: 50%;
    padding: 5px 13px;
}
</style>
<script>
export default {

    props: {
        modalShow: {
            type: Boolean
        }
    },

    data() {
        return {
            show: false
        }
    },

    mounted() {
        console.log(this.modalShow)
    },
    watch: {
        modalShow(newVal) {
            this.show = newVal;
        }
    },
    methods: {
        close() {
            console.log('close')
            this.$emit('close')
        }
    }
}
</script>
