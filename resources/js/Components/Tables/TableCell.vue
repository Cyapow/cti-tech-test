<template>
  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
    <component
      :is="cellComponent(column.type || 'text')"
      :column="column"
      :item="item"
      :data-route="dataRoute"
      :data-prop="dataProp"
      :bindings="bindings"
    />
  </td>
</template>
<script>
import TableEditLink from 'components/Tables/EditLink';
import TableImage from 'components/Tables/Image';
import TableText from 'components/Tables/Text';
import TableBoolean from 'components/Tables/Boolean';
import TableShowLink from 'components/Tables/ShowLink';
import TableCurrency from 'components/Tables/Currency';

export default {
  components: {
    TableEditLink,
    TableImage,
    TableText,
    TableBoolean,
    TableShowLink,
    TableCurrency,
  },
  props: {
    column: {
      type: Object,
      default: () => {},
    },
    item: {
      type: Object,
      default: () => {},
    },
    dataProp: {
      type: String,
      default: '',
    },
    dataRoute: {
      type: String,
      default: '',
    },
    bindings: {
      type: String,
      default: () => {},
    },
  },
  methods: {
    cellComponent(itemType) {
      return `table-${itemType.toLowerCase()}`;
    },
  },
};
</script>
