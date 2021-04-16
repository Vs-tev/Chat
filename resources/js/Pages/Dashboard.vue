<template>
    <app-layout>
        <div class=" max-w-7xl mx-auto px-1  sm:px-6 lg:px-8 pt-1 md:pt-8 h-screen md:h-screen-minus-100">
            <div class="sm:mx-10 border bg-white shadow-2xl rounded-2xl h-full">
               <div class="grid grid-cols-6 h-full">
                   <div :class="onSmallScreen === false ? 'block' : 'hidden md:block' " class="col-span-6 block md:col-span-2 border-r w-full overflow-hidden rounded-tr-2xl md:rounded-tr-none rounded-tl-2xl">
                       <div class="flex items-center justify-between">
                           <div class="pl-6 py-6 sm:pr-6 bg-white w-full h-20">
                              <input type="text" class="input w-full" placeholder="Search" v-model="search_user_name" @keyup="getUsers">
                           </div>
                        <jet-dropdown align="right" width="48" class="sm:hidden">
                          <template #trigger class="">
                              <span class="inline-flex rounded-md">
                                  <button type="button" class="border border-transparent mt-2 px-4 text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition">
                                      <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-dots-vertical" width="28" height="28" viewBox="0 0 24 24" stroke-width="1.5" stroke="#597e8d" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                          <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                          <circle cx="12" cy="12" r="1" />
                                          <circle cx="12" cy="19" r="1" />
                                          <circle cx="12" cy="5" r="1" />
                                        </svg>
                                  </button>
                              </span>
                          </template>

                          <template #content >
                              <!-- Account Management -->
                              <div class="block px-4 py-2 text-xs text-gray-400">
                                  Manage Account
                              </div>

                              <jet-dropdown-link :href="route('profile.show')">
                                  Profile
                              </jet-dropdown-link>

                              <jet-dropdown-link :href="route('api-tokens.index')" v-if="$page.props.jetstream.hasApiFeatures">
                                  API Tokens
                              </jet-dropdown-link>

                              <div class="border-t border-gray-100"></div>

                              <!-- Authentication -->
                              <form @submit.prevent="logout">
                                  <jet-dropdown-link as="button">
                                      Log Out
                                  </jet-dropdown-link>
                              </form>
                          </template>
                        </jet-dropdown>
                       </div>
                     
                        <div v-if="users.length" class="py-4 overflow-auto h-90  relative ">
                            <chat-user  :last_message="last_message" :received_user_id="received_user_id" :users="users" v-on:setUser="setUser($event)"></chat-user>
                        </div>
                         <div v-else class="flex justify-center items-center -mt-20 h-full">
                           <div>
                              <svg xmlns="http://www.w3.org/2000/svg" class="m-auto" width="62" height="62" viewBox="0 0 24 24" stroke-width="1" stroke="#6b7280" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <circle cx="9" cy="7" r="4" />
                                <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                                <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                                <path d="M21 21v-2a4 4 0 0 0 -3 -3.85" />
                              </svg>
                               <div class="font-lg text-gray-500 ">No user found</div>
                            </div>
                         </div>
                   </div>

                   <!-- right -->
                   <div :class="onSmallScreen === true ? 'block' : 'hidden md:block' " class="col-span-6  md:col-span-4 relative h-full" v-if="this.selected_user.length !== 0">
                       <div class="bg-gray-50 w-full pt-3 px-3 h-20 rounded-tl-2xl md:rounded-tl-none rounded-tr-2xl">
                           <div class="flex items-center py-2">
                             <div class="flex items-center cursor-pointer" @click="onSmallScreen = false">
                                <div class="block md:hidden">
                                  <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 fill-current " width="20" height="20" viewBox="0 0 24 24" stroke-width="1.5" stroke="#111827" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                    <line x1="5" y1="12" x2="19" y2="12" />
                                    <line x1="5" y1="12" x2="11" y2="18" />
                                    <line x1="5" y1="12" x2="11" y2="6" />
                                  </svg>
                                </div>
                                <img :src="'/storage/'+ selected_user.profile_photo_path" alt="selected user" class="rounded-full shadow-lg h-10 min-w-10 w-10 object-cover">
                             </div>

                                <div class="w-100 truncate">
                                    <span class="text-base pl-4 font-semibold text-gray-900">{{selected_user.name}}</span>
                                    <div class="text-sm pl-4 font-light text-gray-500">{{selected_user.email}}</div>
                                </div>
                               
                           </div>
                       </div>

                         <!-- messages -->
                      <div ref="feed" class="overflow-y-auto h-165 bottom w-full absolute bottom-20 top-20 flex flex-col flex-no-wrap">
                          <chat-message :messages="messages" :selected_user="selected_user"></chat-message>
                      </div>

                       <!--send message  -->
                       <div class="absolute w-full bottom-0 h-16">
                            <div class="flex px-4 ">
                                <input type="text" @keyup.enter="sendMessage" v-model="text_message" class="input w-full bg-gray-50 mr-4" placeholder="Type Your Message">
                                <div @click="sendMessage" class="flex justify-center items-center p-2 border border-gray-400 rounded-full cursor-pointer hover:shadow-xl hover:bg-gray-100">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 fill-current text-gray-100" width="24" height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="#bcbcbc" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                    <line x1="10" y1="14" x2="21" y2="3" />
                                    <path d="M21 3l-6.5 18a0.55 .55 0 0 1 -1 0l-3.5 -7l-7 -3.5a0.55 .55 0 0 1 0 -1l18 -6.5" />
                                    </svg>
                                </div>
                            </div>
                       </div>
                   </div>
                   <div v-else class="col-span-6 hidden md:block md:col-span-4 relative h-full">
                     <div class="flex justify-center items-center h-full">
                        <div class="text-center">
                          <svg xmlns="http://www.w3.org/2000/svg" class="m-auto" width="130" height="130" viewBox="0 0 24 24" stroke-width="0.5" stroke="#6b7280" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                            <path d="M21 14l-3 -3h-7a1 1 0 0 1 -1 -1v-6a1 1 0 0 1 1 -1h9a1 1 0 0 1 1 1v10" />
                            <path d="M14 15v2a1 1 0 0 1 -1 1h-7l-3 3v-10a1 1 0 0 1 1 -1h2" />
                          </svg>
                          <h1 class="text-gray-500 font-medium">Select friend and start conversation</h1>
                        </div>
                     
                       </div>
                   </div>
               </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
import ChatUser from "@/ChatComponents/User";
import ChatMessage from "@/ChatComponents/Message";
import JetDropdown from "@/Jetstream/Dropdown";
import JetDropdownLink from "@/Jetstream/DropdownLink";

export default {
  props: ["user"],

  components: {
    AppLayout,
    ChatUser,
    ChatMessage,
    JetDropdown,
    JetDropdownLink,
  },

  data() {
    return {
      search_user_name: "",
      users: [],
      messages: [],
      last_message: [],
      selected_user: [],
      text_message: "",
      onSmallScreen: false,
      received_user_id: "",
    };
  },

  mounted() {
    this.getUsers();
  },

  watch: {
    users(val, oldVal) {
      console.log("changed: ", val.id, " | was: ", oldVal.id);
      if (oldVal) {
        this.disconnect(oldVal);
      }
    },

    users() {
      this.connect();
    },

    messages(newVal, OldVal) {
      if (newVal) {
        this.scrollToBottom();
      }
    },
  },

  methods: {
    connect() {
      let vm = this;
      window.Echo.private("chat." + this.$props.user.id).listen(
        ".New message",
        (data) => {
          if (this.selected_user.conversation_id) {
            this.getMessages();
          }
          this.received_user_id = data.user.id;
          this.lastMessage(data.userToNotify.message);
          console.log(data);
        }
      );
    },

    disconnect(oldVal) {
      window.Echo.leave("chat." + oldVal.id);
    },

    scrollToBottom() {
      setTimeout(() => {
        this.$refs.feed.scrollTop =
          this.$refs.feed.scrollHeight - this.$refs.feed.clientHeight;
      }, 50);
    },

    getUsers() {
      axios
        .get("/users", {
          params: {
            search_user_name: this.search_user_name,
          },
        })
        .then((response) => {
          this.users = response.data;
          //console.log(this.users);
        })
        .catch((error) => {
          console.log(error);
        });
    },

    setUser(user) {
      this.selected_user = user;
      this.getMessages();
      this.setMessageAsRead(user);
    },

    lastMessage(newMessage) {
      this.last_message = newMessage;
      console.log(newMessage);
    },

    getMessages() {
      this.onSmallScreen = true;
      axios
        .get("/selected_user_messages/" + this.selected_user.id)
        .then((response) => {
          this.messages = response.data;
        })
        .catch((error) => {
          console.log(error);
        });
    },

    sendMessage() {
      if (
        this.selected_user.length === 0 ||
        this.text_message == "" ||
        !this.text_message.trim().length
      ) {
        return false;
      }
      axios
        .post("/send_message/" + this.selected_user.id, {
          message: this.text_message,
          user: this.selected_user,
        })
        .then((response) => {
          if (response.status == 200) {
            this.text_message = "";
            console.log(response);
            this.getMessages();
          }
        })
        .catch((error) => {
          if (error.response) {
            false;
          }
        });
    },

    setMessageAsRead(user) {
      axios
        .post("/set_messages_as_read", {
          selected_user: user,
        })
        .then((response) => {
          if (response.status == 200) {
            //this.getUsers();
          }
        })
        .catch((error) => {
          if (error.response) {
            false;
          }
        });
    },
  },
};
</script>
