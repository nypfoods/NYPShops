function ledger_data() {
    return {
        trn: {
            trndate: current_date(),
            trntype: "Debit",
            trnbook: "Primary"
        }
    };
}