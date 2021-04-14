<template>

<ul class="list-none ">
    <li v-for="user in users" :key="user.id"  class="w-full px-6 hover:bg-gray-100 cursor-pointer transition duration-150 ease-in-out">
        <div @click="setUser(user)" class="flex items-center py-2">
            <img :src="'/storage/'+ user.profile_photo_path" alt="loading.." class="rounded-full text-xs text-gray-400 font-medium shadow-lg min-h-16 h-16 min-w-16 w-16 flex justify-center items-center object-cover"> 
             <div class="relative" v-if="(user.message_count > 0 || received_user_id == user.id) && active_user == true">
              <span class="absolute text-4xl text-yellow-600 -ml-4">&#8226;</span> 
            </div>
            <div class="w-3/4 truncate">
                <div class="text-base pl-2 text-gray-800 font-semibold">{{user.name}}</div>
                <div class="flex justify-start items-center pl-2">
                  <div class="text-base text-gray-400 font-semibold w-2/3 truncate" :class="((user.message_count > 0 || received_user_id == user.id) && active_user == true) ? 'text-gray-900 font-bold' : '' " v-html="(last_message.length && received_user_id == user.id) ? last_message : user.last_message"></div>
                  <div class="text-sm text-gray-400 font-semibold" v-html="((user.message_count > 0 || received_user_id == user.id) && active_user == true) ? '' : user.last_message_date"></div>
                </div>
            </div>
             
        </div>
    </li>
</ul>
</template>
<script>
export default {
  props: ["received_user_id", "users", "last_message"],
  data() {
    return {
      active_user: true,
    };
  },

  watch: {
    last_message() {
      this.active_user = true;
    },
  },

  methods: {
    setUser: function (user) {
      this.$emit("setUser", user);
      this.active_user = false;
    },
  },
};
</script>