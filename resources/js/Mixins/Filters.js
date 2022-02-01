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

export const Countries = {
    computed: {
        countriesSelect: function () {
            return this.pivot.countries.map(function(item) {
                return {
                    code: item.id,
                    label: item.name
                }
            })
        }
    },
    props: {
        pivot: Object
    }
}

export const Bets = {
    computed: {
        betsSelect: function () {
            return this.pivot.bets.map(function(item) {
                return {
                    code: item.id,
                    label: item.name
                }
            })
        }
    },
    props: {
        pivot: Object
    }
}

export const DropGuides = {
    computed: {
        dropGuidesSelect: function () {
            return this.pivot.dropGuides.map(function(value, key) {
                return {
                    code: key,
                    label: value
                }
            })
        }
    },
    props: {
        pivot: Object
    }
}

export const Drops = {
    computed: {
        dropsSelect: function () {
            let drops = this.pivot.drops
            return Object.keys(drops).map(function(item) {
                return {
                    code: item,
                    label: item
                }
            })
        }
    },
    props: {
        pivot: Object
    }
}

export const Responsible = {
    computed: {
        responsibleSelect: function () {
            return this.pivot.responsible.map(function(item) {
                return {
                    code: item.id,
                    label: item.name
                }
            })
        }
    },
    props: {
        pivot: Object
    }
}
//
// export const Common = {
//     method: {
//         filterTable: function (val, queryKey) {
//             let value = queryKey === 'withdrawn_bk' ? val.target.checked : val.target.value;
//             let queryParam = queryKey + '=' + value;
//             window.history.pushState({
//                 path: window.location.href
//             }, '', window.location.href + '?' + queryParam);
//             this.updateFilterTable()
//         },
//         updateFilterTable: function() {
//             let params = location.search
//                 .slice(1)
//                 .split('&')
//                 .map(p => p.split('='))
//                 .reduce((obj, [key, value]) => ({ ...obj, [key]: value }), {});
//             console.log(params)
//             this.$inertia.get(route('bk.index'), params, { replace: true, preserveState: true })
//         },
//         resetFilterTable: function () {
//             console.log(window.location.href.split("?")[0]);
//             window.history.pushState({
//                 path: window.location.href
//             }, '', window.location.href.split("?")[0]);
//             this.$inertia.get(route('bk.index'))
//         }
//     }
// }
