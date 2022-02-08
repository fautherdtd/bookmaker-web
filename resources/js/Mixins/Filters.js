import mapValues from "lodash/mapValues";
import throttle from "lodash/throttle";
import pickBy from "lodash/pickBy";

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
                    id: item.id,
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
                    id: item.id,
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
                    id: item.id,
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
            console.log(this.pivot.drops)
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
                    id: item.id,
                    label: item.name
                }
            })
        }
    },
    props: {
        pivot: Object
    }
}

export const Common = {
    data: function () {
        return {
            filter: {
                country_id: null,
                drop: null,
                bet_id: null,
                drop_guide: null,
                status: null,
                responsible: null,
                withdrawn: null,
                type_id: null,
            }
        }
    },
    methods: {
        resetFilterTable: function () {
            this.filter = mapValues(this.filter, () => null)
        },
    },
    watch: {
        filter: {
            deep: true,
            handler: throttle(function () {
                console.log(this.filter)
                this.$inertia.get(route(route().current()),
                    pickBy(this.filter),
                    { preserveState: true }
                )}, 150),
        },
    },
}
