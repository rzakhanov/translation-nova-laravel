<template>
  <div>
    <Head title="Translation"/>

    <Heading class="mb-6">Translation</Heading>

    <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
      <div
          class="flex flex-col md:flex-row md:items-center py-3 border-b border-gray-200 dark:border-gray-700">
        <div class="flex items-center w-full max-w-xs h-12 relative z-50 ml-3">
          <div class="flex-1 relative">
            <div class="relative">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                   width="20" height="24" class="inline-block absolute ml-2 text-gray-400" role="presentation"
                   style="top: 4px;">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
              </svg>
              <input dusk="global-search" type="search" placeholder="Enter keyword or value to search"
                     class="appearance-none rounded-full h-8 pl-10 w-full bg-gray-100 dark:bg-gray-900 dark:focus:bg-gray-800 focus:bg-white focus:outline-none focus:ring focus:ring-primary-200 dark:focus:ring-gray-600"
                     role="search" aria-label="Search" aria-expanded="false" spellcheck="false"
                     v-model="this.search_key" @keyup="this.getWords()">
            </div>

          </div>

        </div>
        <div class="flex items-center flex-1">

          <div class="h-9 ml-auto flex items-center pr-2 md:pr-3">
            <div class="hidden md:flex px-2"></div>
            <div class="flex h-9 hover:bg-gray-100 dark:hover:bg-gray-700 rounded"
                 dusk="filter-selector">
              <button aria-expanded="false"
                      class="rounded active:outline-none active:ring focus:outline-none focus:ring focus:ring-primary-200 dark:focus:ring-gray-600"
                      type="button"><span class="sr-only">Filter Dropdown</span>
                <div class="align-middle">

                  <a size="md"
                     class="flex-shrink-0 shadow rounded focus:outline-none ring-primary-200 dark:ring-gray-600 focus:ring bg-primary-500 hover:bg-primary-400 active:bg-primary-600 text-white dark:text-gray-800 inline-flex items-center font-bold px-4 h-9 text-sm flex-shrink-0"
                     dusk="create-button" href="#" @click="this.createIndexPopup=true"><span
                      class="hidden md:inline-block">Create index</span>
                  </a>
                </div>
              </button>
            </div>
          </div>
        </div>
      </div>
      <div class="relative">
        <div class="overflow-hidden overflow-x-auto relative">
          <table class="w-full divide-y divide-gray-100 dark:divide-gray-700 ">
            <thead class="bg-gray-50 dark:bg-gray-800">
            <tr>
              <th class="text-left px-2 whitespace-nowrap uppercase text-gray-500 text-xxs tracking-wide py-2">
                <span>Group</span>
              </th>
              <th class="text-left px-2 whitespace-nowrap uppercase text-gray-500 text-xxs tracking-wide py-2">
                <span>Index</span>
              </th>
              <th v-for="(item, index) in this.collect.languages" :key="index"
                  class="text-left px-2 whitespace-nowrap uppercase text-gray-500 text-xxs tracking-wide py-2">
                <span>{{ item }}</span>
              </th>

              <th class="text-right px-2 whitespace-nowrap uppercase text-gray-500 text-xxs tracking-wide py-2">
                Controls
              </th>
            </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
            <template v-for="(translation_keys, group) in this.collect.all_indexes" :key="group">
              <tr dusk="3-row" class="group" v-for="(word_value, word_key) in translation_keys"
                  :key="word_key" @dblclick="this.updateProps(group,word_key,this.collect.indexes[group])">

                <td class="py-2 cursor-pointer td-fit pl-5 pr-5 dark:bg-gray-800 group-hover:bg-gray-50 dark:group-hover:bg-gray-900">
                  <span class="bg-yellow-500 p-1 rounded text-white" v-html="this.searched(group)"></span>
                </td>

                <td class="py-2 cursor-pointer td-fit pl-5 pr-5 dark:bg-gray-800 group-hover:bg-gray-50 dark:group-hover:bg-gray-900">
                  <span class="bg-sky-100 p-1 rounded text-primary-800" v-html="this.searched(word_key)"></span>
                </td>

                <template v-for="(item, short_lang) in this.collect.languages" :key="index">
                  <td class="py-2 cursor-pointer  pl-5 pr-5 dark:bg-gray-800 group-hover:bg-gray-50 dark:group-hover:bg-gray-900">
                    <b v-html="this.searched(this.collect.indexes[group][short_lang][word_key])"></b>
                  </td>
                </template>

                <!--controls -->
                <td class="py-2 cursor-pointer px-2 td-fit text-right align-middle dark:bg-gray-800 group-hover:bg-gray-50 dark:group-hover:bg-gray-900">
                  <div class="flex items-center justify-end space-x-0 text-gray-400">
                    <a @click="this.updateProps(group,word_key,this.collect.indexes[group])"
                       aria-label="Edit"
                       class="toolbar-button hover:text-primary-500 px-2 disabled:opacity-50 disabled:pointer-events-none v-popper--has-tooltip"
                       href="#">
                      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                           stroke="currentColor" width="24" height="24" class="inline-block"
                           role="presentation">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                      </svg>
                    </a>
                    <button @click="this.deletedKeys(group,word_key)" aria-label="Delete"
                            data-testid="teams-items-0-delete-button"
                            class="toolbar-button hover:text-primary-500 px-2 disabled:opacity-50 disabled:pointer-events-none v-popper--has-tooltip">
                      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                           stroke="currentColor" width="24" height="24" class="inline-block"
                           role="presentation">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                      </svg>
                    </button>
                  </div>
                </td>
              </tr>
            </template>

            </tbody>
          </table>
        </div>
      </div>
    </div>

    <!-- Delete -->
    <SelfPopup :modalShow="this.deletedKeyPopup" @close="this.deletedKeyPopup=false">
      <div class="mx-auto bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden">
        <h3
            class="uppercase tracking-wide font-bold text-xs border-b border-gray-100 dark:border-gray-700 py-4 px-8">
          Delete translated index
        </h3>
        <div class="py-3 px-8"><p class="leading-normal">Are you sure you want to delete the selected index?</p>
        </div>
        <div class="bg-gray-100 dark:bg-gray-700 px-6 py-3 flex">
          <div class="ml-auto">
            <button @click="this.deletedKeyPopup=false" size="lg" align="center" component="button"
                    type="button" data-testid="cancel-button"
                    dusk="cancel-delete-button"
                    class="mr-3 appearance-none bg-transparent font-bold text-gray-400 hover:text-gray-300 active:text-gray-500 dark:text-gray-500 dark:hover:text-gray-400 dark:active:text-gray-600 dark:hover:bg-gray-800 mr-3 cursor-pointer rounded text-sm font-bold focus:outline-none focus:ring ring-primary-200 dark:ring-gray-600 inline-flex items-center justify-center h-9 px-3 mr-3 appearance-none bg-transparent font-bold text-gray-400 hover:text-gray-300 active:text-gray-500 dark:text-gray-500 dark:hover:text-gray-400 dark:active:text-gray-600 dark:hover:bg-gray-800 mr-3">
              Cancel
            </button>
            <button @click=" this.deletedKeysAction() "
                    class="shadow relative bg-red-500 hover:bg-red-400 text-white cursor-pointer rounded text-sm font-bold focus:outline-none focus:ring ring-primary-200 dark:ring-gray-600 inline-flex items-center justify-center h-9 px-3 shadow relative bg-red-500 hover:bg-red-400 text-white">
              <span class="">Delete</span>
            </button>
          </div>
        </div>
      </div>
    </SelfPopup>

    <!-- Create -->
    <SelfPopup :modalShow="this.createIndexPopup" @close="this.createIndexPopup=false">
      <div style="width:500px" class="mx-auto bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden">
        <h3
            class="uppercase tracking-wide font-bold text-xs border-b border-gray-100 dark:border-gray-700 py-4 px-8">
          Create new translation index
        </h3>
        <div class="bg-gray-100 dark:bg-gray-700 px-6 py-3 flex">
          <div class="w-full">
            <div class="mb-4">
              <label class="block text-gray-700 text-sm font-bold mb-2" for="index_name">
                Index name:
              </label>
              <input v-model="createIndexProps.index"
                     class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                     id="index_name" type="text" placeholder="Index name">
            </div>
            <div class="mb-4">
              <label class="block text-gray-700 text-sm font-bold mb-2" for="index_group">
                Select group:
              </label>
              <select v-model="createIndexProps.group"
                      class="shadow bg-white border rounded w-full py-2 px-3 text-gray-700 focus:outline-none focus:shadow-outline">
                <option v-for="(group,ind) in this.collect.groups">{{ group }}</option>
              </select>
            </div>

            <div class="mb-4 p-1 pb-4 bg-sky-100" v-for="(languages,index) in this.collect.languages"
                 style="background: rgb(191 214 222)">
              <label class="block text-gray-700 text-sm font-bold mb-2" for="index_name">
                <p class="text-primary-800 ">{{ languages }} ({{ index }}) :</p>
              </label>
              <textarea v-model="createIndexProps.translation[index]"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        id="index_name" type="text"></textarea>
            </div>

            <div class="flex justify-end">

              <button @click="this.createIndex()"
                      class="shadow relative bg-green-500 hover:bg-green-400 text-white cursor-pointer rounded text-sm font-bold focus:outline-none focus:ring ring-primary-200 dark:ring-gray-600 inline-flex items-center justify-center h-9 px-3 shadow relative bg-green-500 hover:bg-green-400 text-white">
                <span class="">Create</span>
              </button>
            </div>
          </div>
        </div>
      </div>
    </SelfPopup>

    <!-- Update -->
    <SelfPopup :modalShow="this.updateIndexPopup" @close="this.updateIndexPopup=false">
      <div style="width:500px" class="mx-auto bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden">
        <h3
            class="uppercase tracking-wide font-bold text-xs border-b border-gray-100 dark:border-gray-700 py-4 px-8">
          Update translation index
        </h3>
        <div class="bg-gray-100 dark:bg-gray-700 px-6 py-3 flex">
          <div class="w-full">
            <div class="mb-4">
              <label class="block text-gray-700 text-sm font-bold mb-2" for="index_name">
                Index name:
              </label>
              <input v-model="updateIndexProps.index"
                     class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                     id="index_name" type="text" placeholder="Index name">
            </div>
            <div class="mb-4">
              <label class="block text-gray-700 text-sm font-bold mb-2" for="index_group">
                Select group:
              </label>
              <input v-model="updateIndexProps.group"
                     class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                     id="index_name" type="text" placeholder="Group" disabled>
            </div>

            <div class="mb-4 p-1 pb-4 bg-sky-100" v-for="(languages,index) in this.collect.languages"
                 style="background: rgb(191 214 222)">
              <label class="block text-gray-700 text-sm font-bold mb-2" for="index_name">
                <p class="text-primary-800 ">{{ languages }} ({{ index }}) :</p>
              </label>
              <textarea v-model="this.updateIndexProps.translation[index]"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        id="index_name" type="text"></textarea>
            </div>

            <div class="flex justify-end">

              <button @click="this.updateIndex()"
                      class="shadow relative bg-green-500 hover:bg-green-400 text-white cursor-pointer rounded text-sm font-bold focus:outline-none focus:ring ring-primary-200 dark:ring-gray-600 inline-flex items-center justify-center h-9 px-3 shadow relative bg-green-500 hover:bg-green-400 text-white">
                <span class="">Update</span>
              </button>
            </div>
          </div>
        </div>
      </div>
    </SelfPopup>
  </div>
</template>

<script>
import SelfPopup from "./SelfPopup.vue";

export default {
  components: {SelfPopup},
  mounted() {
    this.getWords()
  },
  data() {
    return {
      collect: {},
      search_key: "",

      createIndexPopup: false,
      createIndexProps: {
        translation: {}

      },

      updateIndexPopup: false,
      updateIndexProps: {
        translation: {}
      },

      deletedKeyPopup: false,
      deletedKeyProps: {},
    }
  },
  methods: {

    getWords: function () {
      Nova.request({
        url: '/nova-vendor/translation/get?search_key=' + this.search_key,
        method: 'get',
        data: {}
      }).then((res) => {
        this.collect = res.data;
      });
    },

    deletedKeys: function (group, index) {
      this.deletedKeyProps = {
        group, index
      }
      this.deletedKeyPopup = true;
    },
    deletedKeysAction: function () {
      console.log(this.deletedKeyProps)
      this.deletedKeyPopup = false;

      Nova.request({
        url: '/nova-vendor/translation/delete',
        method: 'delete',
        data: this.deletedKeyProps
      }).then(res => {
        this.getWords()
        Nova.success('Translation index deleted');
      }).catch(res => {
        this.getWords()
        Nova.error(res.response.data.message);
      });
    },
    createIndex: function () {
      Nova.request({
        url: '/nova-vendor/translation/save',
        method: 'POST',
        data: {
          ...this.createIndexProps
        }
      }).then((res) => {
        if (res.data.response === true) {
          this.getWords()
          Nova.success('Translation was created');
          this.createIndexPopup = false;
          this.createIndexProps = {
            translation: {}
          };
        }
      }).catch(res => {
        Nova.error(res.response.data.message);
      });
    },
    updateProps: function (group, word_key, translations) {
      let up_tr_data = {};
      for (let shrtLang in this.collect.languages) {
        up_tr_data[shrtLang] = translations[shrtLang][word_key];
      }

      this.updateIndexProps = {
        old_index: word_key,
        index: word_key,
        group: group,
        translation: up_tr_data,
      }
      this.updateIndexPopup = true;
    },
    updateIndex: function () {
      Nova.request({
        url: '/nova-vendor/translation/update',
        method: 'PUT',
        data: {
          ...this.updateIndexProps
        }
      }).then((res) => {
        if (res.data.response === true) {
          this.getWords()
          Nova.success('Translation was updated');
          this.updateIndexPopup = false;
          this.updateIndexProps = {
            translation: {}
          };
        }
      }).catch(res => {
        Nova.error(res.response.data.message);
      });
    },

    searched: function (item) {
      if (item && this.search_key) {
        let re = new RegExp(`(${this.search_key})`, 'gi');
        return item.replace(re, "<i class='bg-red-500 text-white py-1'>$1</i>")
      }
      return item;
    }
  }
}
</script>

