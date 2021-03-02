<template>
  <div class="col-xl-4 col-lg-4 col-md-4 col-sm-3 col-3">
      <div class="users-container">
          <div class="chat-search-box">
              <div class="input-group">
                  <input class="form-control" placeholder="ابحث">
                  <div class="input-group-btn">
                      <button type="button" class="btn">
                          <i class="fa fa-search"></i>
                      </button>
                  </div>
              </div>
          </div>
        <ul class="users" dir="rtl">
          <li class="person" v-for="contact in sortedContacts" :key="contact.id" @click="selectContact(contact)" :class="{ 'selected': contact == selected  }" data-chat="person1">
              <div class="user">
                  <img :src="contact.profile_image" :alt="contact.name">
                  <span class="unread" v-if="contact.unread">{{ contact.unread }}</span>
              </div>
              <p class="name-time">
                  <span class="name">{{ contact.name }}</span>
                  <span class="time">{{ contact.email }}</span>
              </p>
          </li>
        </ul>
      </div>
    </div>
</template>


<script>
  export default {
    props: {
      contacts: {
        type: Array,
        default: []
      }
    },
    data(){
      return {
        selected : this.contacts.length ? this.contacts[0] : null
      }
    },
    methods: {
      selectContact(contact){
        this.selected = contact;
        this.$emit('selected', contact);
      }
    },
    computed: {
      sortedContacts() {
        return _.sortBy(this.contacts, [(contact) => {
          if(contact == this.selected){
            return Infinity;
          }
          return contact.unread;
        }]).reverse()
      }
    }
  }
</script>



<style>
  .users{
    max-height: 600px;
    overflow: scroll;
  }
  .unread {
    background: #82e0a8;
    color: #fff;
    position: absolute;
    right: 30px;
    top: 40px;
    display: flex;
    font-weight: 700;
    min-width: 20px;
    justify-content: center;
    align-items: center;
    line-height: 20px;
    font-size: 12px;
    padding: 0 4px;
    border-radius: 50%;
}
</style>
