<template>
    <div class="mt-auto" v-if="messages">
        <div v-for="message in messages" :key="message.id" class="mx-4 my-4 flex w-auto" :class="selected_user.id !== message.user_id ? 'justify-end ': '' ">
            <div v-if="message.user && selected_user.id == message.user_id">
                 <img 
                :src="'/storage/'+ message.user.profile_photo_path"
                alt="selected user"
                class="rounded-full shadow-lg h-8 min-w-8 w-8 object-cover">
            </div>
               
            <div class="p-2 md:p-3 rounded-lg w-auto xs:max-w-sm md:max-w-sm lg:max-w-md" :class="selected_user.id !== message.user_id ? 'bg-indigo-50 mr-2' : 'bg-gray-100 ml-2' ">
                <p class="text-base text-gray-600">{{message.message}}</p>
                    <div class="text-gray-400 text-xs text-right mt-2">{{message.created_at}}</div>
            </div>
             <div v-if="message.user && selected_user.id !== message.user_id">
            <img v-if="selected_user.id !== message.user_id"
                :src="'/storage/'+ message.user.profile_photo_path"
                alt="selected user"
                class="rounded-full shadow-lg h-8 min-w-8 w-8 object-cover">
             </div>   
        </div>
    </div> 
</template>
<script>
export default {
  name: ["Messsage"],
  props: ["messages", "selected_user"],
};
</script>