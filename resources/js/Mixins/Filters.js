export const Currencies = {
    computed: {
        currenciesSelect: function () {
            return this.pivot.currencies.map(function(item) {
                return {
                    code: item.code,
                    label: item.name
                }
            })
        }
    },
    props: {
        pivot: Object
    }
};

export const BkList = {
    computed: {
        bkSelect: function () {
            return this.pivot.bk.data.map(function(item) {
                let values = [item.country, item.drop, item.bk, item.cash];
                return {
                    code: item.id,
                    label: values.join(' ')
                }
            })
        }
    },
    props: {
        pivot: Object
    }
}

export const TypePayments = {
    computed: {
        typePaymentsSelect: function () {
            return this.pivot.type.map(function(item) {
                return {
                    code: item.id,
                    label: item.title
                }
            })
        }
    },
    props: {
        pivot: Object
    }
}

export const Statuses = {
    computed: {
        statusesSelect: function () {
            let statuses = this.pivot.status
            return Object.keys(statuses).map(function(value, index) {
                return {
                    code: value,
                    label: statuses[value]
                }
            })
        }
    },
    props: {
        pivot: Object
    }
}
