<template>
    <div>
        <button class="btn btn-primary ml-4" @click="followUser" v-text="buttonText"></button>
    </div>
</template>

<script>
    export default
 {  
        props:  ['userId', 'follows'],

        mounted() {
            console.log('Component mounted.')
        },

        data: function(){
            return {
                status: this.follows,
            }
        },

        methods: {
            followUser(){
                axios.post('/follow/' + this.userId)
                .then(response=> {                // when got response,
                    this.status = ! this.status; // toggle button status (follow/unfollow) (?) 

                    console.log(response.data);
            })
                .catch(errors =>{
                if (errors.response.status == 401) {
                    window.location = '/login';
                }
            }); 

        }
    
    },
        computed:{
            buttonText(){
                return (this.status) ? 'Unfollow' : 'Follow';
            //whether ststus - if this.status == true ?(then) show 'Unfollow', :(otherwise) show 'Follow'
            }  
        }
}
</script>
