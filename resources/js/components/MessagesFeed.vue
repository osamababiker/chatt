<template>
  <div if="contact" class="feed" ref="feed">
    <ul class="chat-box chatContainerScroll" >
      <li v-for="message in messages" :class="`chat-${message.to == contact.id ? 'right' : 'left'}`"  :key="message.id">
          <!--
          <div class="chat-avatar">
              <img :src="message.from_contact.profile_image" :alt="message.from_contact.name">
              <div class="chat-name">{{ message.from_contact.name }}</div>
          </div>
        -->
          <div class="chat-text">{{ message.message }}</div>
          <!--
          <div class="chat-hour">08:55 <span class="fa fa-check-circle"></span></div>
        -->
      </li>
    </ul>
  </div>
</template>


<script>
  export default{
    props: {
      contact: {
        type: Object,
        required: true
      },
      messages: {
        type: Array,
        required: true
      }
    },
    methods: {
      scrollToBottom(){
        setTimeout(() => {
          this.$refs.feed.scrollTop = this.$refs.feed.scrollHeight - this.$refs.feed.clientHeight;
        }, 50);
      }
    },
    watch: {
      contact(contact){
        this.scrollToBottom();
      },
      messages(messages){
        this.scrollToBottom();
      }
    }
  }
</script>

<style>
  .feed{
    height: 500px;
    overflow: scroll;
  }
</style>
