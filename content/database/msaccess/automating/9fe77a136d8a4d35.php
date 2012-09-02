<h1>Start Access</h1>
<div class="date">01.01.2007</div>


<p>If you've got the D5 patch, you can use the TAccessApplication component to start Access. Drop one one a form, and if its AutoConnect property is true, Access will start automatically when your program starts; if it's false, just call</p>
<p>  AccessApplication1.Connect;</p>
<p>when you want to start. To use a running instance of Access, if there is one, set the ConnectKind property of TAccessApplication to ckRunningOrNew, or to ckRunningInstance if you don't want to start a new instance if Access isn't running.</p>
<p>Once Access has started, you can connect other components, such as TAccessReport, using their ConnectTo methods:</p>
<pre>
  AccessApplication1.Connect;
  AccessApplication1.Visible := True;
  AccessApplication1.OpenCurrentDatabase('C:\Office\Samples\Northwind.mdb', True);
  AccessApplication1.DoCmd.OpenReport('Sales by Year', acViewDesign, EmptyParam, EmptyParam);
  AccessReport1.ConnectTo(AccessApplication1.Reports['Sales by Year']);
  AccessReport1.Caption := 'Annual sales - from bad to worse';
</pre>
<p>Note that a workbook or worksheet must be open before you can connect to it. </p>
<p>If you haven't got the patch for D5, starting Access is a bit different, because there is no TAccessApplication component. (This is because Microsoft declared the Application object as hidden in the type library.) However you can create an Application object in the same way as it was done in D4 (see below), and then connect the Access components to it. See Access- common problems for an example.</p>
