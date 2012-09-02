<h1>Как корректно определить изменения в оборудовании Plug &amp; Play?</h1>
<div class="date">01.01.2007</div>


<pre>
type 
               TForm1 = class(TForm) 
                 Button1: TButton; 
               private 
                 { Private declarations } 
                 procedure WMDeviceChange(var Message: TMessage); 
                   message WM_DEVICECHANGE; 
               public 
                 { Public declarations } 
               end; 
 
             var 
               Form1: TForm1; 
 
             implementation 
 
             {$R *.DFM} 
 
             const DBT_DEVICEARRIVAL = $8000; 
             const DBT_DEVICEQUERYREMOVE = $8001; 
             const DBT_DEVICEQUERYREMOVEFAILED = $8002; 
             const DBT_DEVICEREMOVEPENDING = $8003; 
             const DBT_DEVICEREMOVECOMPLETE = $8004; 
             const DBT_DEVICETYPESPECIFIC = $8005; 
             const DBT_CONFIGCHANGED = $0018; 
 
             procedure TForm1.WMDeviceChange(var Message: TMessage); 
             var 
               s : string; 
             begin 
             {Do Something here} 
               case Message.wParam of 
                 DBT_DEVICEARRIVAL : 
                   s := 'A device has been inserted and is now available'; 
                 DBT_DEVICEQUERYREMOVE: begin 
                   s := 'Permission to remove a device is requested'; 
                   ShowMessage(s); 
                  {True grants premission} 
                   Message.Result := integer(true); 
                   exit; 
                 end; 
                 DBT_DEVICEQUERYREMOVEFAILED : 
                   s := 'Request to remove a device has been canceled'; 
                 DBT_DEVICEREMOVEPENDING : 
                   s := 'Device is about to be removed'; 
                 DBT_DEVICEREMOVECOMPLETE : 
                   s := 'Device has been removed'; 
                 DBT_DEVICETYPESPECIFIC : 
                   s := 'Device-specific event'; 
                 DBT_CONFIGCHANGED : 
                   s:= 'Current configuration has changed' 
                 else s := 'Unknown Device Message'; 
               end; 
               ShowMessage(s); 
               inherited; 
             end; 
</pre>

