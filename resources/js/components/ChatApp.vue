<template>
    <div class="row no-gutters">
      <Conversation :contact="selectedContact" :messages="messages" @new="saveNewMessages" />
      <ContactsList :contacts="contacts" @selected="startConversationWith" />
    </div>
</template>

<script>
    import Conversation from './Conversation';
    import ContactsList from './ContactsList';
    export default {
      props: {
        user: {
          type: Object,
          required: true
        }
      },
      data(){
        return {
          selectedContact : null,
          messages: [],
          contacts: []
        }
      },
      mounted() {

        Echo.private(`messages.${this.user.id}`)
            .listen('NewMessage', (e) => {
              this.handleIncoming(e.message);
            });


        axios.get('/contacts')
          .then((response) => {
            this.contacts = response.data
          });
      },
      methods: {
        startConversationWith(contact){
          this.updateUnreadCount(contact,true);

          axios.get(`/conversation/${contact.id}`)
            .then((response) => {
              this.messages = response.data;
              this.selectedContact = contact;
            });
        },
        saveNewMessages(message){
          this.messages.push(message);
        },
        handleIncoming(message){
          if(this.selectedContact && message.from == this.selectedContact.id){
            this.saveNewMessages(message);
            return ;
          }

          this.updateUnreadCount(message.from_contact,false);
        },
        updateUnreadCount(contact,reset){
          this.contacts = this.contacts.map((single) => {
              
            if(single.id != contact.id){
              return single;
            }
            if(reset)
              single.unread = 0;
            else
              single.unread += 1;

            return single;
          });
        }
      },
      components: {Conversation , ContactsList}
    }
</script>
