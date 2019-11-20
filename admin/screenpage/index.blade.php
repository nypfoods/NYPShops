<head>
    <title>Screen Details</title>
</head>
<tabs :tabs="['Add Screens']">
    <template slot="Add Screens">
        <form id="myfrm" action="javascript:void(0)" class="grid">
            <dbinput type="select" fcol="link" v-model="dfcol.name" label="Sceen Path *" :options="menulist" required :wordcase="false">
            </dbinput>
            <dbinput label="Update" type="switch" v-model="dfcol.upd" class="smallswitch">
                <template slot="default" slot-scope="d">
                    <b>{{d.val?"YES":"NO"}}</b>
                </template>
            </dbinput>
            <dbinput label="Delete" type="switch" v-model="dfcol.del" class="smallswitch">
                <template slot="default" slot-scope="d">
                    <b>{{d.val?"YES":"NO"}}</b>
                </template>
            </dbinput>
            <dbinput label="Login" type="switch" v-model="dfcol.lg" class="smallswitch">
                <template slot="default" slot-scope="d">
                    <b>{{d.val?"YES":"NO"}}</b>
                </template>
            </dbinput>
            <dbinput label="Out-Screen" type="switch" v-model="dfcol.slg" class="smallswitch">
                <template slot="default" slot-scope="d">
                    <b>{{d.val?"YES":"NO"}}</b>
                </template>
            </dbinput>
            <dbinput sql="select * from (SELECT did,dname FROM `department` 
            UNION 
            SELECT desid as did,desname as dname FROM `designation` 
            UNION 
            SELECT uid as did,uname as dname FROM `employee`
            UNION
            SELECT 'online_franchise' as did,'online_franchise' as dname
            UNION
            SELECT 'online_vendor' as did,'online_vendor' as dname
            UNION
            SELECT 'online_employee' as did,'online_vendor' as dname
            ) as temp" type="multi-search" fcol="dname" label="User|Department|Designation*" @multi-select="(val,ms)=>{xpath=ms.col('dname');}">
            </dbinput>
            <dbinput type="submit" label="" @click="addscreens">UPDATE</dbinput>
        </form>
        <dbtable name="scrmod" sql="select * from screens" :fcol="['display','name','slg','lg','upd','del','icon','cicon','xpath']" :dcol="{name:'Screen Path',xpath:'Username|Department|Designation',slg:'Out-Screen',lg:'Login',upd:'Update',del:'Delete',display:'Display'}" :coltype="{lg:'switch',upd:'switch',del:'switch'}" :updkey="['name']" @delete="(df)=>{df();}" :freez="['name','lg','upd','del','xpath','slg']">
        </dbtable>
    </template>
</tabs>
<vue>#node</vue>