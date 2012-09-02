<h1>Убрать ScrollBars от TTreeView</h1>
<div class="date">01.01.2007</div>


<pre>
uses CommCtrl;
procedure tNoScrollbarsTreeview.createparams(var params: TCreateParams);
begin
  inherited;
  params.style := params.style or TVS_NOSCROLL;
end;
</pre>
