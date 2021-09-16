<template>
  <div class="flex flex-col">
    <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
      <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
        <div v-if="searchable">
          <div class="shadow flex rounded-lg">
            <input
              v-model="term"
              class="w-full rounded p-2 border-gray-200 focus:outline-none focus:border-gray-200 focus:ring-0"
              type="search"
              placeholder="Search..."
              @search="search"
            />
          </div>
        </div>
        <div v-if="data.data.length > 0" class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg my-2">
          <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
              <tr>
                <table-header
                  :columns="columns"
                  :sorting-column="sortingColumn"
                  :sorting-asc="sortingAsc"
                  @sort="sort"
                />
                <th v-if="editAction || deleteAction || viewAction" scope="col" class="relative px-6 py-3 w-28">
                  <span class="sr-only">Options</span>
                </th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
              <tr v-for="item in data.data" :key="item.id">
                <table-cell
                  v-for="column in columns"
                  :key="column.key"
                  :column="column"
                  :data-route="dataRoute"
                  :data-prop="dataProp"
                  :item="item"
                />
                <td
                  v-if="editAction || deleteAction || viewAction"
                  class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium"
                >
                  <div class="flex">
                    <Link
                      v-if="viewAction && dataRoute"
                      title="View"
                      :href="
                        route(`${dataRoute}.show`, {
                          [dataProp]: item.id,
                        })
                      "
                    >
                      <SearchIcon class="h-4 w-4" />
                    </Link>
                    <Link
                      v-if="editAction && dataRoute"
                      title="Edit"
                      :href="
                        route(`${dataRoute}.edit`, {
                          [dataProp]: item.id,
                        })
                      "
                    >
                      <PencilIcon class="h-4 w-4" />
                    </Link>
                    <button
                      v-if="deleteAction && dataRoute"
                      type="button"
                      title="Delete"
                      class="ml-4"
                      @click="
                        selectedItem = item.id;
                        confirmDeletion = true;
                      "
                    >
                      <TrashIcon class="h4 w-4" />
                    </button>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        <blank-slate v-else>No results found</blank-slate>
        <pagination :data="data" />
      </div>
    </div>
  </div>
  <delete-modal
    :title="`Delete ${objectName}`"
    :show="confirmDeletion"
    @close="confirmDeletion = false"
    @delete="deleteItem(selectedItem)"
  >
    <p class="text-sm text-gray-500">Are you sure you want to delete this {{ objectName }}?</p>
  </delete-modal>
</template>

<script>
import { PencilIcon } from '@heroicons/vue/solid';
import { TrashIcon, SearchIcon } from '@heroicons/vue/outline';
import Pagination from 'components/Pagination';
import { Link } from '@inertiajs/inertia-vue3';
import DeleteModal from 'components/DeleteModal';
import BlankSlate from 'components/BlankSlate';
import TableHeader from 'components/Tables/TableHeader';
import TableCell from 'components/Tables/TableCell';

export default {
  components: {
    TableCell,
    TableHeader,
    BlankSlate,
    Link,
    Pagination,
    PencilIcon,
    TrashIcon,
    SearchIcon,
    DeleteModal,
  },
  props: {
    columns: {
      type: Object,
      default: () => {},
    },
    data: {
      type: Object,
      default: () => {},
    },
    dataRoute: {
      type: String,
      default: '',
    },
    dataProp: {
      type: String,
      default: '',
    },
    editAction: {
      type: Boolean,
      default: false,
    },
    deleteAction: {
      type: Boolean,
      default: false,
    },
    viewAction: {
      type: Boolean,
      default: false,
    },
    objectName: {
      type: String,
      default: 'product',
    },
    searchable: {
      type: Boolean,
      default: false,
    },
  },
  data() {
    return {
      sortingColumn: this.$page.props.sortingColumn ?? '',
      sortingAsc: this.$page.props.sortingAsc ?? false,
      sortKey: this.$page.props.sortKey ?? null,
      term: this.$page.props.term ?? null,
      confirmDeletion: false,
      selectedItem: null,
      processing: false,
    };
  },
  methods: {
    cellComponent(itemType) {
      return `table-${itemType.toLowerCase()}`;
    },
    sort(column) {
      this.sortKey = null;
      if (this.sortingColumn === column && !this.sortingAsc) {
        this.sortingAsc = true;
        this.sortingColumn = '';
      } else if (this.sortingColumn === column) {
        this.sortingAsc = !this.sortingAsc;
      } else {
        this.sortingAsc = true;
        this.sortingColumn = column;
      }

      if (this.sortingColumn !== '') {
        this.sortKey = (this.sortingAsc ? '+' : '-') + this.sortingColumn;
      }

      this.$inertia.get(
        route(`${this.dataRoute}.index`, {
          term: this.term,
          sort: this.sortKey,
        }),
        { preserveState: true }
      );
    },
    search() {
      this.$inertia.get(
        route(`${this.dataRoute}.index`, {
          term: this.term,
          sort: this.sortKey,
        }),
        { preserveState: true }
      );
    },
    deleteItem(itemId) {
      this.processing = true;
      this.$inertia.delete(
        route(`${this.dataRoute}.destroy`, {
          [this.dataProp]: itemId,
        }),
        {
          onFinish: () => {
            this.processing = false;
            this.confirmDeletion = false;
          },
        }
      );
    },
  },
};
</script>
