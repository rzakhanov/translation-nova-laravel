<template>
  <div>
    <Head title="Languages"/>

    <Heading class="mb-6">Languages</Heading>

    <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
      <div
          class="flex flex-col md:flex-row md:items-center py-3 border-b border-gray-200 dark:border-gray-700">

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
                     dusk="create-button" href="#" @click="this.createLanguagePopup=true"><span
                      class="hidden md:inline-block">Create language</span>
                  </a>
                </div>
              </button>
            </div>
          </div>
        </div>
      </div>
      <div class="relative">
        <div class="overflow-hidden overflow-x-auto relative">
          <table class=" divide-y divide-gray-100 dark:divide-gray-700 ">
            <thead class="bg-gray-50 dark:bg-gray-800">
            <tr>
              <th class="text-left px-2 whitespace-nowrap uppercase text-gray-500 text-xxs tracking-wide py-2">
                <span>Lang index</span>
              </th>
              <th class="text-left px-2 whitespace-nowrap uppercase text-gray-500 text-xxs tracking-wide py-2">
                <span>Description</span>
              </th>

              <th class="text-right px-2 whitespace-nowrap uppercase text-gray-500 text-xxs tracking-wide py-2">
                Controls
              </th>
            </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
            <tr v-for="(description, index) in this.collect" :key="index" class="group" @dblclick="this.updateProps(index,description)">

              <td class="py-2 cursor-pointer td-fit pl-5 pr-5 dark:bg-gray-800 group-hover:bg-gray-50 dark:group-hover:bg-gray-900">
                <span class="bg-yellow-500 p-1 rounded text-white">{{index}}</span>
              </td>

              <td class="py-2 cursor-pointer td-fit pl-5 pr-5 dark:bg-gray-800 group-hover:bg-gray-50 dark:group-hover:bg-gray-900">
                <span class="bg-green-500 p-1 rounded text-white">{{description}}</span>
              </td>

              <!--controls -->
              <td class="py-2 cursor-pointer px-2 td-fit text-right align-middle dark:bg-gray-800 group-hover:bg-gray-50 dark:group-hover:bg-gray-900">
                <div class="flex items-center justify-end space-x-0 text-gray-400">
                  <a @click="this.updateProps(index,description)"
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
                  <button @click="this.deletedLanguages(index)" aria-label="Delete"
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

            </tbody>
          </table>
        </div>
      </div>
    </div>

    <!-- Delete -->
    <SelfPopup :modalShow="this.deletedLanguagePopup" @close="this.deletedLanguagePopup=false">
      <div class="mx-auto bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden">
         <h3
            class="uppercase tracking-wide font-bold text-xs border-b border-gray-100 dark:border-gray-700 py-4 px-8">
          Delete language
        </h3>
        <div class="py-3 px-8"><p class="leading-normal">Are you sure you want to delete the selected language?</p>
        </div>
        <div class="bg-gray-100 dark:bg-gray-700 px-6 py-3 flex">
          <div class="ml-auto">
            <button @click="this.deletedLanguagePopup=false" size="lg" align="center" component="button"
                    type="button" data-testid="cancel-button"
                    dusk="cancel-delete-button"
                    class="mr-3 appearance-none bg-transparent font-bold text-gray-400 hover:text-gray-300 active:text-gray-500 dark:text-gray-500 dark:hover:text-gray-400 dark:active:text-gray-600 dark:hover:bg-gray-800 mr-3 cursor-pointer rounded text-sm font-bold focus:outline-none focus:ring ring-primary-200 dark:ring-gray-600 inline-flex items-center justify-center h-9 px-3 mr-3 appearance-none bg-transparent font-bold text-gray-400 hover:text-gray-300 active:text-gray-500 dark:text-gray-500 dark:hover:text-gray-400 dark:active:text-gray-600 dark:hover:bg-gray-800 mr-3">
              Cancel
            </button>
            <button @click=" this.deletedLanguagesAction()"
                    class="shadow relative bg-red-500 hover:bg-red-400 text-white cursor-pointer rounded text-sm font-bold focus:outline-none focus:ring ring-primary-200 dark:ring-gray-600 inline-flex items-center justify-center h-9 px-3 shadow relative bg-red-500 hover:bg-red-400 text-white">
              <span class="">Delete</span>
            </button>
          </div>
        </div>
      </div>
    </SelfPopup>

    <!-- Create -->
    <SelfPopup :modalShow="this.createLanguagePopup" @close="this.createLanguagePopup=false">
      <div style="width:500px" class="mx-auto bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden">
        <h3
            class="uppercase tracking-wide font-bold text-xs border-b border-gray-100 dark:border-gray-700 py-4 px-8">
          Create new language
        </h3>
        <div class="bg-gray-100 dark:bg-gray-700 px-6 py-3 flex">
          <div class="w-full">
            <div class="mb-4">
              <label class="block text-gray-700 text-sm font-bold mb-2" for="index_name">
                Index name:
              </label>
              <input v-model="createLanguageProps.index"
                     class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                     id="index_name" type="text" placeholder="Index name">
            </div>


            <div class="mb-4 p-1 pb-4 bg-sky-100">
              <label class="block text-gray-700 text-sm font-bold mb-2" for="index_name">
                <p class="text-primary-800 ">Description:</p>
              </label>
              <textarea v-model="createLanguageProps.description"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        id="index_name" type="text"></textarea>
            </div>

            <div class="flex justify-end">

              <button @click="this.createLanguage()"
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
                  Update language
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


                      <div class="mb-4 p-1 pb-4 bg-sky-100">
                          <label class="block text-gray-700 text-sm font-bold mb-2" for="index_name">
                              <p class="text-primary-800 ">Description:</p>
                          </label>
                          <textarea v-model="updateIndexProps.description"
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
    this.get()
  },
  data() {
    return {
      collect: {},

      createLanguagePopup: false,
      createLanguageProps: {},

      updateIndexPopup: false,
      updateIndexProps: {},

      deletedLanguagePopup: false,
      deletedLanguageProps: {},
    }
  },
  methods: {

    get: function () {
      Nova.request({
        url: '/nova-vendor/translation/languages/list',
        method: 'get',
        data: {}
      }).then((res) => {
        this.collect = res.data;
      });
    },

    deletedLanguages: function (index) {
      this.deletedLanguageProps = {
        index
      }
      this.deletedLanguagePopup = true;
    },

    deletedLanguagesAction: function () {
      console.log(this.deletedLanguageProps)
      this.deletedLanguagePopup = false;

      Nova.request({
        url: '/nova-vendor/translation/languages/delete',
        method: 'delete',
        data: this.deletedLanguageProps
      }).then(res => {
        this.get()
        Nova.success('Language was deleted');
      }).catch(res => {
        this.get()
        Nova.error(res.response.data.message);
      });
    },

    createLanguage: function () {
      Nova.request({
        url: '/nova-vendor/translation/languages/save',
        method: 'POST',
        data: {
          ...this.createLanguageProps
        }
      }).then((res) => {
        if (res.data.response === true) {
          this.get()
          Nova.success('Language was created');
          this.createLanguagePopup = false;
          this.createLanguageProps = { };
        }
      }).catch(res => {
        Nova.error(res.response.data.message);
      });
    },
    updateProps: function (index, description) {

      this.updateIndexProps = {
        index:index,
        old_index:index,
        description:description
      }
      this.updateIndexPopup = true;
    },
    updateIndex: function () {
      Nova.request({
        url: '/nova-vendor/translation/languages/update',
        method: 'PUT',
        data: {
          ...this.updateIndexProps
        }
      }).then((res) => {
        if (res.data.response === true) {
          this.get()
          Nova.success('Language was updated');
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

