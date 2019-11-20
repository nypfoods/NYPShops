<vue>#node</vue>
<tabs :tabs="['Send Mail With Document']">
    <div slot="Send Mail With Document" class="fgrid">
        <form autocomplete="off" name="myfrm" action="javascript:emailoffer()" @invalid="" @onnext="" style="display: grid;grid-template-columns:1fr 1fr">
            <div>
                <dbinput type="text" label="Type" v-model="flds.offer" required></dbinput>
                <dbinput type="email" label="Email" v-model="flds.email" required></dbinput>
                <dbinput type="text" label="Subject" v-model="flds.sub" required></dbinput>
                <dbinput type="textarea" label="Body" v-model="flds.body" required></dbinput>
                <dbinput type="submit" value="">Submit</dbinput>
            </div>
            <div>
                <dbinput v-if="flds.offer && flds.email" class="a4ph a4pw" name="fregapl" type="file" label="Upload File" :upload="`/upload/${ldb}/employee/${flds.email.split('.').join('')}/${flds.offer}`" filename="doc.pdf" required="true" formate="application" ftype="pdf" v-model="myfile" :timeout="1000">
                </dbinput>
            </div>
        </form>
    </div>
</tabs>