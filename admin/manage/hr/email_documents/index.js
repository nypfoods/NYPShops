function email_documents_data() {
    return {
        flds: {},
        myfile: "",
        ldb: ldb
    };
}

async function emailoffer(...arr) {
    let ddata = vueapp.flds;

    await callServerMethod("sendOfferDoc", { email: ddata.email, sub: ddata.sub, body: ddata.body, folnam: ddata.offer });
    let ic = tinfo("Email sending please wait....");
    ic();
    talert("Email sent ", "Information...!", () => {});

}

/*function hadeleFields(name, row) {

    if (name == 'Offer Letter') {
        this.flds["sub"] = "Job Offer From NYP Foods LLP";
        this.flds["body"] = "Dear [Candidate First and Last Name],Congratulations on your offer from NYP Foods LLP! We are delighted to offer you the position of [Job Title] with an anticipated start date of [start date].As discussed [over the phone, during your interview, etc.], please find attached your detailed offer letter. If you choose to accept this offer, please sign, scan, and email your letter to me at [email address] by [decision deadline].[If you are attaching other documents that need to be read and signed, mention those here].In the meantime, please don’t hesitate to reach out to me, either through email or by calling me directly at [your phone number] if you should have any questions or concerns.We are looking forward to hearing from you and hope you’ll join our team!Best regards,NYP Foods LLP Team";
    } else if (name == 'Relieving Letter') {
        this.flds["sub"] = "Relieving Letter From NYP Foods";
        this.flds["body"] = "Dear [Candidate First and Last Name],Best regards,NYP Foods LLP Team";

    } else if (name == 'Experience Letter') {
        this.flds["sub"] = "Experience Letter From NYP Foods";
        this.flds["body"] = "Dear [Candidate First and Last Name],Best regards,NYP Foods LLP Team";

    } else if (name == 'Salary Slip') {
        this.flds["sub"] = "Salary Slip From NYP Foods";
        this.flds["body"] = "Dear [Candidate First and Last Name],Best regards,NYP Foods LLP Team";
    } else if (name == 'Relieving Letter') {
        this.flds["sub"] = "Letter Head From NYP Foods";
        this.flds["body"] = "";
    }

}*/