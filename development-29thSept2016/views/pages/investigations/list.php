<rn:meta title="Investigations" template="standard.php" clickstream="list" login_required="true" />

<div class="rn_Hero">
    <div class="rn_HeroInner">
        <div class="rn_HeroCopy">
		<h1>Ongoing Investigations</h1>
           <!-- <h1>#rn:msg:SUBMIT_QUESTION_OUR_SUPPORT_TEAM_CMD#</h1>
            <p>#rn:msg:OUR_DEDICATED_RESPOND_WITHIN_48_HOURS_MSG#</p>!-->
        </div>
        <div class="translucent">

        </div>
        <br>

    </div>
</div>
 <rn:container report_id="100012">
<div class="rn_PageContent rn_AskQuestion rn_Container cfl" style='min-height:600px'>
    <rn:widget path='custom/customer_feedback/CustomListFilter' page_entity="investigations"  page_action='/app/investigations/list/' />
    <rn:widget path='custom/action_items/StatusFilter' action="/app/investigations/list" label_name="Choose Status" entity_type="investigations"  />
    <!--
    <rn:widget path='custom/customer_feedback/ComplaintReportFilter' action="/app/investigations/list" label_name="Choose Complaints"  />
   -->
    <rn:widget path="custom/action_items/CBOMultilinelist"  per_page="10"/>
    <div style="float:right;clear:both">
	<!--<rn:widget path="reports/BasicPaginator" report_id="100066" per_page="5"/> -->
	<rn:widget path="custom/action_items/CBOPaginator"  per_page="10"/>
	</div>
</div>
  </rn:container>
