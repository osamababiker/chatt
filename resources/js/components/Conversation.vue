<template>
  <div class="col-xl-8 col-lg-8 col-md-8 col-sm-9 col-9" dir="rtl">
      <div class="selected-user">
          <span>الى: <span class="name">{{ contact ? contact.name : '.....' }}</span></span>
      </div>
      <div class="chat-container"> 
        <MessagesFeed :contact="contact" :messages="messages"/>
        <MessageComposer @send="sendMessage"/>
      </div>
    </div>
</template>


<script>
  import MessagesFeed from './MessagesFeed';
  import MessageComposer from './MessageComposer';
  export default {
    props: {
      contact: {
        type: Object,
        default: null
      },
      messages: {
        type: Array,
        default: []
      }
    },
    methods: {
      sendMessage(message){
        if(!this.contact){
          return ;
        }

        axios.post('/conversation/send',{
          contact_id: this.contact.id,
          message: message
        }).then((response) => {
          this.$emit('new', response.data);
        });
      }
    },
    components: {MessagesFeed , MessageComposer}
  }
</script>


<style lang="scss" scoped>
.conversation {
    flex: 5;
    display: flex;
    flex-direction: column;
    justify-content: space-between;

    h1 {
        font-size: 20px;
        padding: 10px;
        margin: 0;
        border-bottom: 1px dashed lightgray;
    }
}
</style>
