<h1>Создать новый Outlook Contact?</h1>
<div class="date">01.01.2007</div>


<pre class="delphi">
uses
  ComObj, Variants, SysUtils;
 
type
  TContact = record
    LastName: string;
    FirstName : string;
    Company : string;
    // ###  Further properties. See MSDN
  end;
 
 
  //------------------------------------------------------------------------------
{:Add outlook contact
 
@param ContactFolderPath The contact path. E.g.: '' for default contact folder,
  'SubFolder\Sub2\Test' for subfolders
@param Contact The contact informations.
@author 19.09.2003 Michael Klemm}
  //------------------------------------------------------------------------------
procedure OutlookAddContact(ContactFolderPath : string; Contact : TContact);
const
  olFolderContacts = $0000000A;
var
  Outlook : OleVariant;
  NameSpace : OleVariant;
  ContactsRoot : OleVariant;
  ContactsFolder : OleVariant;
  OutlookContact : OleVariant;
  SubFolderName : string;
  Position : integer;
  Found : boolean;
  Counter : integer;
  TestContactFolder : OleVariant;
begin
  // Connect to outlook
  Outlook := CreateOleObject('Outlook.Application');
  // Get name space
  NameSpace := Outlook.GetNameSpace('MAPI');
  // Get root contacts folder
  ContactsRoot := NameSpace.GetDefaultFolder(olFolderContacts);
  // Iterate to subfolder
  ContactsFolder := ContactsRoot;
  while ContactFolderPath &lt;&gt; '' do
  begin
    // Extract next subfolder
    Position := Pos('\', ContactFolderPath);
    if Position &gt; 0 then
    begin
      SubFolderName := Copy(ContactFolderPath, 1, Position - 1);
      ContactFolderPath := Copy(ContactFolderPath, Position + 1, Length(ContactFolderPath));
    end
    else
    begin
      SubFolderName := ContactFolderPath;
      ContactFolderPath := '';
    end;
    if SubFolderName = '' then
      Break;
    // Search subfolder
    Found := False;
    for Counter := 1 to ContactsFolder.Folders.Count do
    begin
      TestContactFolder := ContactsRoot.Folders.Item(Counter);
      if LowerCase(TestContactFolder.Name) = LowerCase(SubFolderName) then
      begin
        ContactsFolder := TestContactFolder;
        Found := True;
        Break;
      end;
    end;
    // If not found create
    if not Found then
      ContactsFolder := ContactsFolder.Folders.Add(SubFolderName);
  end;
  // Create contact item
  OutlookContact := ContactsFolder.Items.Add;
  // Fill contact information
  OutlookContact.FirstName := Contact.FirstName;
  OutlookContact.LastName := Contact.LastName;
  OutlookContact.CompanyName := Contact.Company;
 
  // ### Further properties
 
  // Save contact
  OutlookContact.Save;
  // Disconnect from outlook
  Outlook := Unassigned;
end;
</pre>

<p>Взято с сайта <a href="https://www.swissdelphicenter.ch/en/tipsindex.php" target="_blank">https://www.swissdelphicenter.ch/en/tipsindex.php</a></p>
