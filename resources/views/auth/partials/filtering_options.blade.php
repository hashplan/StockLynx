<script type="text/javascript">
    $(document).ready(function(){
        $( ".filtering_options" ).select2( { placeholder: "Filtering Options"} );
    });
</script>
<div style="margin:10px;">
    <select class="filtering_options" style="width: 210px">
        <option></option>
        <optgroup label="Filter By">
            <option value="1">Name</option>
            <option value="2">Value</option>
            <option value="3">Cost</option>
            <option value="4">Dept</option>
            <option value="5">Date</option>
        </optgroup>
    </select>
</div>
