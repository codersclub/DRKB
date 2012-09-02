<h1>Использование записей для хранения информации полей</h1>
<div class="date">01.01.2007</div>


<pre>
 { 
   You sometimes wish to store multiple information in a given class like 
   in the example: alltogether when it belongs together. 
   Thus accessing this information from out of the class can be achieved 
   using property declaration. Its a good way to "clean your code" and 
   make it as "logic" as possible. 
   You also may have to store or load information from your class using 
   file or stream technology. This can be done at once for the recorded 
   information from within the given class. 
}
 
 type
   TPersonRecord = Record
      FirstName: String;
      LastName: String;
      BirthDate: TDate;
      End;
 
   TForm4 = class(TForm)
     Button1: TButton;
     procedure Button1Click(Sender: TObject);
   private
     fActualUser: TPersonRecord;
     ...
     procedure SaveActualUser(S: TFileStream); // it's an example 
    procedure LoadActualUser(S: TFileStream);
     ...
   public
     property FirstName: string read  fActualUser.FirstName
                                write fActualUser.FirstName;
     property LastName : string read  fActualUser.LastName
                                write fActualUser.LastName;
     property BirthDate: TDate  read  fActualUser.BirthDate
                                write fActualUser.BirthDate;
   end;
 
 procedure TForm4.SaveActualUser(S: TFileStream);
 begin
   // All that stuff at once in your Stream 
  S.Write(fActualUser, SizeOf(fActualUser))
 end;
 
 procedure TForm4.LoadActualUser(S: TFileStream);
 begin
   // All that stuff at once back in your class 
  S.Read(fActualUser, SizeOf(fActualUser));
 end;
</pre>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
&nbsp;</p>
