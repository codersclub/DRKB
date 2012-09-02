<h1>Как возвращать сообщения на родном языке компьютера?</h1>
<div class="date">01.01.2007</div>


<pre>
{ 
  Call inLanguage like this to get the German text else return english 
  if you use different coutntry codes you can do more 
}
 
 {############### FGetLanguageSettings ############################ 
 # Author: Walter Verhoeven 
 # Date:   14.Sep.2000 
 # Coming From: InLanguage 
 #  Next Event: NONE 
 #  Parameters: NONE 
 #   Objective: See the users regional settings and return Country #number code 
 #   Change: 
 #     DD-MMM-YYYYY ¦Programmer 
 #                1) 
 # 
 ########################################################}
 
   function FGetLanguageSettings: Integer;
 var
   OutputBuffer: PChar;
   SelectedLCID: LCID;               //DWORD constand in Windows.pas 
begin
   OutputBuffer := StrAlloc(4);     //alocate memory for the PChar 
  try
     try
       SelectedLCID := GetUserDefaultLCID;
       GetLocaleInfo(SelectedLCID, LOCALE_ICOUNTRY, OutputBuffer, 3);
       Result := StrToInt(OutputBuffer);
     except
       Result := 49;   //german 
      Abort;
     end;
   finally
     StrDispose(OutputBuffer);   //alway's free the memory alocated 
  end;
 end;
 
 {############## INLanguage ####################################### 
 # Author: Walter Verhoeven 
 # Date:   .Jun.2000 
 # Coming From: 
 #  Next Event: FGetLanguageSettings 
 #  Parameters: Eglish and german text 
 #   Objective: provide a method to return 
 #              english or german results based on the 
 # users window prefered language setting. 
 #   Change: 
 #     DD-MMM-YYYYY ¦Programmer 
 #                1) 
 # 
 ##############################################################}
 
 
   function INLanguage(English, German: string): string;
 begin
   case FGetLanguageSettings of
     49: Result  := German;   // Return the german string 
    43: Result  := German;   // If the PC has a german preferance 
    41: Result  := German;
     352: Result := German;
     else
       Result := English;      // if not german then english 
  end;
 end;
 
 
 procedure TForm1.Button1Click(Sender: TObject);
 begin
   ShowMessage(Format(INLanguage('My %s English Word',
     'Riesiges %s Software-Angebot'), ['Hopla']));
 end;
 
</pre>
<p>Взято с сайта: <a href="https://www.swissdelphicenter.ch" target="_blank">https://www.swissdelphicenter.ch</a></p>

