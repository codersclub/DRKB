<h1>InputBox для ввода пароля</h1>
<div class="date">01.01.2007</div>


<pre>
const
   InputBoxMessage = WM_USER + 200;
 
 type
   TForm1 = class(TForm)
     Button1: TButton;
     procedure Button1Click(Sender: TObject);
   private
     procedure InputBoxSetPasswordChar(var Msg: TMessage); message InputBoxMessage;
   public
   end;
 
 var
   Form1: TForm1;
 
 implementation
 
 {$R *.DFM}
 
 procedure TForm1.InputBoxSetPasswordChar(var Msg: TMessage);
 var
   hInputForm, hEdit, hButton: HWND;
 begin
   hInputForm := Screen.Forms[0].Handle;
   if (hInputForm &lt;&gt; 0) then
   begin
     hEdit := FindWindowEx(hInputForm, 0, 'TEdit', nil);
     { 
      // Change button text: 
      hButton := FindWindowEx(hInputForm, 0, 'TButton', nil); 
      SendMessage(hButton, WM_SETTEXT, 0, Integer(PChar('Cancel'))); 
    }
     SendMessage(hEdit, EM_SETPASSWORDCHAR, Ord('*'), 0);
   end;
 end;
 
 procedure TForm1.Button1Click(Sender: TObject);
 var
   InputString: string;
 begin
   PostMessage(Handle, InputBoxMessage, 0, 0);
   InputString := InputBox('Input Box', 'Please Enter a Password', '');
 end;
</pre>

<p>Взято с сайта: <a href="https://www.swissdelphicenter.ch" target="_blank">https://www.swissdelphicenter.ch</a></p>
