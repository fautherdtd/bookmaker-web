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
            let dropGuide = this.pivot.dropGuides
            return Object.keys(dropGuide).map(function(value, key) {
                return {
                    code: value,
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
