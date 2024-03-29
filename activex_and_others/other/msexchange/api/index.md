---
Title: MS Exchange API
Date: 01.01.2007
Source: Delphi Knowledge Base: <https://www.baltsoft.com/>
---


MS Exchange API
===============

MS Exchange API via CDO (Collaboration Data Objects)

CDO (Collaboration Data Objects) Base Library.

(Talking to MS-Exchange server.)

This is a vast subject that is beyond the scope of this article to
detail all here. This library provides the basic building blocks for
someone who wants to develop using CDO. There are many references on the
Net, but your best source is the CDO.HLP file that ships on the Exchange
CD or site
http://www.cdolive.com/start.htmhttp://www.cdolive.com/start.htm. The
cdolive.com site is an excellent reference site which discusses all
aspects including installation, versions and also downloads. (CDO.HLP is
downloadable from here)

My basic class provides the following functionality ..

Utility functions and methods

    function CdoNothing(Obj : OleVariant) : boolean;
    function CdoDefaultProfile : string;
    function VarNothing : IDispatch;
    
    procedure CdoDisposeList(WorkList : TList);
    procedure CdoDisposeObjects(WorkStrings : TStrings);
    procedure CdoDisposeNodes(WorkData : TTreeNodes);

Create constructors that allow Default profile logon,Specific profile
logon and an Impersonated user logon with profile. (This is required for
successful logon in Windows Service Applications)

    constructor Create; overload;
    constructor Create(const Profile : string); overload;
    constructor Create(const Profile : string;
                       const UserName : string;
                       const Domain : string;
                       const Password : string); overload;

Methods for loading stringlists, treeviews etc. and Object iteration.

    function LoadAddressList(StringList : TStrings) : boolean;
    function LoadObjectList(const FolderOle : OleVariant; 
                            List : TList) : boolean;
    function LoadEMailTree(TV : TTreeView; 
                           Expand1stLevel : boolean = false;
                           SubjectMask : string = '') : boolean;
    function LoadContactList(const FolderOle : OleVariant;
                             Items : TStrings) : boolean; overload;
    function LoadContactList(const FolderName : string;
                             Items : TStrings) : boolean; overload;
    procedure ShowContactDetails(Contact : OleVariant);

The above load various lists into stringlists,lists or treeviews.
Freeing of lists,object constructs within these data structures are
freed at each successive call to the load, however the final
Deallocation is the responsibility of the developer, You can do this
yourself or use the utility functions CdoDisposeXXX(). See code
documentation for further understanding.

     
    function First(const FolderOle : OleVariant; 
                   out ItemOle : OleVariant) : boolean;
    function Last(const FolderOle : OleVariant; 
                  out ItemOle : OleVariant) : boolean;
    function Next(const FolderOle : OleVariant; 
                  out ItemOle : OleVariant) : boolean;
    function Prior(const FolderOle : OleVariant; 
                   out ItemOle : OleVariant) : boolean;
    function AsString(const ItemOle : Olevariant; 
                      const FieldIdConstant : DWORD) : string;

The above provide iterations thru object such as Inbox,Contacts etc. The
AsString returns a fields value from the object such as Email
Address,Name,Company Name etc. (There are miriads of these defined in
the CONST section "Field Tags").

Properties

    property CurrentUser : OleVariant read FCurrentUser;
    property Connected : boolean read FConnected;
    property LastErrorMess : string read FlastError;
    property LastErrorCode : DWORD read FlastErrorCode;
    property InBox : OleVariant read FOleInBox;
    property OutBox : OleVariant read FOleOutBox;
    property DeletedItems : Olevariant read FOleDeletedItems;
    property SentItems : Olevariant read FOleSentItems;
    property GlobalAddressList : Olevariant read FOleGlobalAddressList;
    property Contacts : Olevariant read FOleContacts;
    property Session : OleVariant read FOleSession;
    property Version : string read GetFVersion;
    property MyName : string read FMyName;
    property MyEMailAddress : string read FMyEMailAddress;

The Create constructor sets up the predefined objects InBox, OutBox,
DeletedItems, SentItems, GlobalAddressList, Session and Contacts. The
other properties are self explanatary.

As I mentioned earlier the functionality of CDO is vast as objects such
as InBox have many methods and properties that included
Updating,Inserting Deleting etc. The CDO.HLP file will help to expose
these for you. My class is the base of CDO to help simplify building
applications and is probably best demonstrated by code snippet examples.
Believe me a whole book could be written on this subject, but it is well
worth studying as a faster alternative to using MS Outlook API.

    uses Cdo_Lib;
    var
      Cdo: TcdoSession;
      MailItem: OleVariant;
     
      // Iterate thru Emails in InBox
    begin
      Cdo := TCdoSession.Create;
     
      if Cdo.Active then
      begin
        Cdo.First(Cdo.InBox, MailItem);
     
        while true do
        begin
          if not Cdo.Nothing(MailItem) then
          begin
            Subject := MailItem.Subject;
     
            EMailAddress := Cdo.AsString(MailItem.Sender, CdoPR_EMAIL_AT_ADDRESS);
            EMailName := MailItem.Sender.Name;
            BodyText := MailItem.Text;
     
            // Do something with data and delete the EMail
            MailItem.Delete;
            // Get the next Email
          end;
     
          MailItem := Cdo.Next(Cdo.Inbox.MailItem);
        end;
      end;
      Cdo.Free;
    end;

    // Example of loading emails into a treeview and displaying on treeview click
     
    unit UBrowse;
    interface
     
    uses
      Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms, Dialogs,
      ComCtrls, ToolWin, Menus, ExtCtrls, StdCtrls, Buttons, ImgList,
      CDO_Lib;
     
    type
      TFBrowse = class(TForm)
        Panel1: TPanel;
        Panel3: TPanel;
        Label1: TLabel;
        Label2: TLabel;
        lbFrom: TLabel;
        lbDate: TLabel;
        Memo1: TMemo;
        Panel2: TPanel;
        OKBtn: TBitBtn;
        tvCalls: TTreeView;
        ImageList1: TImageList;
        StatusBar1: TStatusBar;
        procedure FormShow(Sender: TObject);
        procedure FormClose(Sender: TObject; var Action: TCloseAction);
        procedure tvCallsClick(Sender: TObject);
        procedure btnPrintClick(Sender: TObject);
      private
        { Private declarations }
        Doc: OleVariant;
        Cdo: TCdoMapiSession;
      public
        { Public declarations }
      end;
     
    var
      FBrowse: TFBrowse;
     
    implementation
     
    {$R *.DFM}
     
    procedure TFBrowse.FormShow(Sender: TObject);
    var
      TN: TTreeNode;
    begin
      Screen.Cursor := crHourGlass;
      Application.ProcessMessages;
      Cdo := TCdoMapiSession.Create;
      Cdo.LoadEMailTree(tvCalls, true, '*Support ---*');
      tvCalls.SortType := stText;
      TN := tvCalls.Items[0];
      TN.Expand(false);
      tvCalls.SetFocus;
      Screen.Cursor := crDefault;
    end;
     
    procedure TFBrowse.FormClose(Sender: TObject; var Action: TCloseAction);
    begin
      CdoDisposeNodes(TvCalls.Items);
      Cdo.Free;
    end;
     
    procedure TFBrowse.tvCallsClick(Sender: TObject);
    var
      TN: TTreeNode;
    begin
      TN := tvCalls.Selected;
      Memo1.Clear;
      lbFrom.Caption := '';
      lbDate.Caption := '';
     
      if TN.Data <> nil then
      begin
        Doc := TOleVarPtr(TN.Data)^;
        btnPrint.Enabled := true;
        Memo1.Text := Doc.Text;
        lbFrom.Caption := Doc.Sender.Name;
        lbDate.Caption := FormatDateTime('dd/mm/yyyy hh:nn', Doc.TimeSent);
      end;
    end;
     
    end.

    unit CDO_Lib;
     
    // =============================================================================
    // CDO and MAPI Library (See CDO.HLP)
    //
    // The object model for the CDO Library is hierarchical. The following table
    // shows the containment hierarchy. Each indented object is a child of the
    // object under which it is indented. An object is the parent of every object
    // at the next level of indentation under it. For example, an Attachments
    // collection and a Recipients collection are both child objects of a
    // Message object, and a Messages collection is a parent object of a
    // Message object. However, a Messages collection is not a parent object of a
    // Recipients collection.
    //
    //  Session
    //        AddressLists collection
    //              AddressList
    //                    Fields collection
    //                          Field
    //                    AddressEntries collection
    //                          AddressEntry
    //                                Fields collection
    //                                      Field
    //                          AddressEntryFilter
    //                                Fields collection
    //                                      Field
    //        Folder (Inbox or Outbox)
    //              Fields collection
    //                    Field
    //              Folders collection
    //                    Folder
    //                          Fields collection
    //                                Field
    //                          [ Folders ... Folder ... ]
    //                          Messages collection
    //                                AppointmentItem
    //                                      RecurrencePattern
    //                                GroupHeader
    //                                MeetingItem
    //                                Message
    //                                      Attachments collection
    //                                            Attachment
    //                                                  Fields collection
    //                                                        Field
    //                                      Fields collection
    //                                            Field
    //                                      Recipients collection
    //                                            Recipient
    //                                                  AddressEntry
    //                                                        Fields collection
    //                                                              Field
    //                                MessageFilter
    //                                      Fields collection
    //                                            Field
    //        InfoStores collection
    //              InfoStore
    //                    Fields collection
    //                          Field
    //                    Folder [as expanded under Folders]
    //
    //  The notation "[ Folders ... Folder ... ]" signifies that any Folder object
    //  can contain a Folders collection of subfolders, and each subfolder can
    //  contain a Folders collection of more subfolders, nested to an
    //  arbitrary level.
    // =============================================================================
     
    interface
     
    uses Forms, Windows, SysUtils, Classes, Registry, ComObj, Variants, ComCtrls,
      Controls, Masks;
     
    const
      // MAPI Property Tags
     
      // Field Tags
      CdoPR_7BIT_DISPLAY_NAME = $39FF001E;
      CdoPR_AB_DEFAULT_DIR = $3D060102;
      CdoPR_AB_DEFAULT_PAB = $3D070102;
      CdoPR_AB_PROVIDER_ID = $36150102;
      CdoPR_AB_PROVIDERS = $3D010102;
      CdoPR_AB_SEARCH_PATH = $3D051102;
      CdoPR_AB_SEARCH_PATH_UPDATE = $3D110102;
      CdoPR_ACCESS = $0FF40003;
      CdoPR_ACCESS_LEVEL = $0FF70003;
      CdoPR_ACCOUNT = $3A00001E;
      CdoPR_ACKNOWLEDGEMENT_MODE = $00010003;
      CdoPR_ADDRTYPE = $3002001E;
      CdoPR_ALTERNATE_RECIPIENT = $3A010102;
      CdoPR_ALTERNATE_RECIPIENT_ALLOWED = $0002000B;
      CdoPR_ANR = $360C001E;
      CdoPR_ASSISTANT = $3A30001E;
      CdoPR_ASSISTANT_TELEPHONE_NUMBER = $3A2E001E;
      CdoPR_ASSOC_CONTENT_COUNT = $36170003;
      CdoPR_ATTACH_ADDITIONAL_INFO = $370F0102;
      CdoPR_ATTACH_DATA_BIN = $37010102;
      CdoPR_ATTACH_DATA_OBJ = $3701000D;
      CdoPR_ATTACH_ENCODING = $37020102;
      CdoPR_ATTACH_EXTENSION = $3703001E;
      CdoPR_ATTACH_FILENAME = $3704001E;
      CdoPR_ATTACH_LONG_FILENAME = $3707001E;
      CdoPR_ATTACH_LONG_PATHNAME = $370D001E;
      CdoPR_ATTACH_METHOD = $37050003;
      CdoPR_ATTACH_MIME_TAG = $370E001E;
      CdoPR_ATTACH_NUM = $0E210003;
      CdoPR_ATTACH_PATHNAME = $3708001E;
      CdoPR_ATTACH_RENDERING = $37090102;
      CdoPR_ATTACH_SIZE = $0E200003;
      CdoPR_ATTACH_TAG = $370A0102;
      CdoPR_ATTACH_TRANSPORT_NAME = $370C001E;
      CdoPR_ATTACHMENT_X400_PARAMETERS = $37000102;
      CdoPR_AUTHORIZING_USERS = $00030102;
      CdoPR_AUTO_FORWARD_COMMENT = $0004001E;
      CdoPR_AUTO_FORWARDED = $0005000B;
      CdoPR_BEEPER_TELEPHONE_NUMBER = $3A21001E;
      CdoPR_BIRTHDAY = $3A420040;
      CdoPR_BODY = $1000001E;
      CdoPR_BODY_CRC = $0E1C0003;
      CdoPR_BUSINESS_ADDRESS_CITY = $3A27001E;
      CdoPR_BUSINESS_ADDRESS_COUNTRY = $3A26001E;
      CdoPR_BUSINESS_ADDRESS_POST_OFFICE_BOX = $3A2B001E;
      CdoPR_BUSINESS_ADDRESS_POSTAL_CODE = $3A2A001E;
      CdoPR_BUSINESS_ADDRESS_STATE_OR_PROVINCE = $3A28001E;
      CdoPR_BUSINESS_ADDRESS_STREET = $3A29001E;
      CdoPR_BUSINESS_FAX_NUMBER = $3A24001E;
      CdoPR_BUSINESS_HOME_PAGE = $3A51001E;
      CdoPR_BUSINESS_TELEPHONE_NUMBER = $3A08001E;
      CdoPR_BUSINESS2_TELEPHONE_NUMBER = $3A1B001E;
      CdoPR_CALLBACK_TELEPHONE_NUMBER = $3A02001E;
      CdoPR_CAR_TELEPHONE_NUMBER = $3A1E001E;
      CdoPR_CELLULAR_TELEPHONE_NUMBER = $3A1C001E;
      CdoPR_CHILDRENS_NAMES = $3A58101E;
      CdoPR_CLIENT_SUBMIT_TIME = $00390040;
      CdoPR_COMMENT = $3004001E;
      CdoPR_COMMON_VIEWS_ENTRYID = $35E60102;
      CdoPR_COMPANY_MAIN_PHONE_NUMBER = $3A57001E;
      CdoPR_COMPANY_NAME = $3A16001E;
      CdoPR_COMPUTER_NETWORK_NAME = $3A49001E;
      CdoPR_CONTACT_ADDRTYPES = $3A54101E;
      CdoPR_CONTACT_DEFAULT_ADDRESS_INDEX = $3A550003;
      CdoPR_CONTACT_EMAIL_ADDRESSES = $3A56101E;
      CdoPR_CONTACT_ENTRYIDS = $3A531102;
      CdoPR_CONTACT_VERSION = $3A520048;
      CdoPR_CONTAINER_CLASS = $3613001E;
      CdoPR_CONTAINER_CONTENTS = $360F000D;
      CdoPR_CONTAINER_FLAGS = $36000003;
      CdoPR_CONTAINER_HIERARCHY = $360E000D;
      CdoPR_CONTAINER_MODIFY_VERSION = $36140014;
      CdoPR_CONTENT_CONFIDENTIALITY_ALGORITHM_ID = $00060102;
      CdoPR_CONTENT_CORRELATOR = $00070102;
      CdoPR_CONTENT_COUNT = $36020003;
      CdoPR_CONTENT_IDENTIFIER = $0008001E;
      CdoPR_CONTENT_INTEGRITY_CHECK = $0C000102;
      CdoPR_CONTENT_LENGTH = $00090003;
      CdoPR_CONTENT_RETURN_REQUESTED = $000A000B;
      CdoPR_CONTENT_UNREAD = $36030003;
      CdoPR_CONTENTS_SORT_ORDER = $360D1003;
      CdoPR_CONTROL_FLAGS = $3F000003;
      CdoPR_CONTROL_ID = $3F070102;
      CdoPR_CONTROL_STRUCTURE = $3F010102;
      CdoPR_CONTROL_TYPE = $3F020003;
      CdoPR_CONVERSATION_INDEX = $00710102;
      CdoPR_CONVERSATION_KEY = $000B0102;
      CdoPR_CONVERSATION_TOPIC = $0070001E;
      CdoPR_CONVERSION_EITS = $000C0102;
      CdoPR_CONVERSION_PROHIBITED = $3A03000B;
      CdoPR_CONVERSION_WITH_LOSS_PROHIBITED = $000D000B;
      CdoPR_CONVERTED_EITS = $000E0102;
      CdoPR_CORRELATE = $0E0C000B;
      CdoPR_CORRELATE_MTSID = $0E0D0102;
      CdoPR_COUNTRY = $3A26001E;
      CdoPR_CREATE_TEMPLATES = $3604000D;
      CdoPR_CREATION_TIME = $30070040;
      CdoPR_CREATION_VERSION = $0E190014;
      CdoPR_CURRENT_VERSION = $0E000014;
      CdoPR_CUSTOMER_ID = $3A4A001E;
      CdoPR_DEF_CREATE_DL = $36110102;
      CdoPR_DEF_CREATE_MAILUSER = $36120102;
      CdoPR_DEFAULT_PROFILE = $3D04000B;
      CdoPR_DEFAULT_STORE = $3400000B;
      CdoPR_DEFAULT_VIEW_ENTRYID = $36160102;
      CdoPR_DEFERRED_DELIVERY_TIME = $000F0040;
      CdoPR_DELEGATION = $007E0102;
      CdoPR_DELETE_AFTER_SUBMIT = $0E01000B;
      CdoPR_DELIVER_TIME = $00100040;
      CdoPR_DELIVERY_POINT = $0C070003;
      CdoPR_DELTAX = $3F030003;
      CdoPR_DELTAY = $3F040003;
      CdoPR_DEPARTMENT_NAME = $3A18001E;
      CdoPR_DEPTH = $30050003;
      CdoPR_DETAILS_TABLE = $3605000D;
      CdoPR_DISC_VAL = $004A000B;
      CdoPR_DISCARD_REASON = $00110003;
      CdoPR_DISCLOSE_RECIPIENTS = $3A04000B;
      CdoPR_DISCLOSURE_OF_RECIPIENTS = $0012000B;
      CdoPR_DISCRETE_VALUES = $0E0E000B;
      CdoPR_DISPLAY_BCC = $0E02001E;
      CdoPR_DISPLAY_CC = $0E03001E;
      CdoPR_DISPLAY_NAME = $3001001E;
      CdoPR_DISPLAY_NAME_PREFIX = $3A45001E;
      CdoPR_DISPLAY_TO = $0E04001E;
      CdoPR_DISPLAY_TYPE = $39000003;
      CdoPR_DL_EXPANSION_HISTORY = $00130102;
      CdoPR_DL_EXPANSION_PROHIBITED = $0014000B;
      CdoPR_EMAIL_ADDRESS = $3003001E;
      CdoPR_EMAIL_AT_ADDRESS = $39FE001E;
      CdoPR_END_DATE = $00610040;
      CdoPR_ENTRYID = $0FFF0102;
      CdoPR_EXPIRY_TIME = $00150040;
      CdoPR_EXPLICIT_CONVERSION = $0C010003;
      CdoPR_FILTERING_HOOKS = $3D080102;
      CdoPR_FINDER_ENTRYID = $35E70102;
      CdoPR_FOLDER_ASSOCIATED_CONTENTS = $3610000D;
      CdoPR_FOLDER_TYPE = $36010003;
      CdoPR_FORM_CATEGORY = $3304001E;
      CdoPR_FORM_CATEGORY_SUB = $3305001E;
      CdoPR_FORM_CLSID = $33020048;
      CdoPR_FORM_CONTACT_NAME = $3303001E;
      CdoPR_FORM_DESIGNER_GUID = $33090048;
      CdoPR_FORM_DESIGNER_NAME = $3308001E;
      CdoPR_FORM_HIDDEN = $3307000B;
      CdoPR_FORM_HOST_MAP = $33061003;
      CdoPR_FORM_MESSAGE_BEHAVIOR = $330A0003;
      CdoPR_FORM_VERSION = $3301001E;
      CdoPR_FTP_SITE = $3A4C001E;
      CdoPR_GENDER = $3A4D0002;
      CdoPR_GENERATION = $3A05001E;
      CdoPR_GIVEN_NAME = $3A06001E;
      CdoPR_GOVERNMENT_ID_NUMBER = $3A07001E;
      CdoPR_HASATTACH = $0E1B000B;
      CdoPR_HEADER_FOLDER_ENTRYID = $3E0A0102;
      CdoPR_HOBBIES = $3A43001E;
      CdoPR_HOME_ADDRESS_CITY = $3A59001E;
      CdoPR_HOME_ADDRESS_COUNTRY = $3A5A001E;
      CdoPR_HOME_ADDRESS_POST_OFFICE_BOX = $3A5E001E;
      CdoPR_HOME_ADDRESS_POSTAL_CODE = $3A5B001E;
      CdoPR_HOME_ADDRESS_STATE_OR_PROVINCE = $3A5C001E;
      CdoPR_HOME_ADDRESS_STREET = $3A5D001E;
      CdoPR_HOME_FAX_NUMBER = $3A25001E;
      CdoPR_HOME_TELEPHONE_NUMBER = $3A09001E;
      CdoPR_HOME2_TELEPHONE_NUMBER = $3A2F001E;
      CdoPR_ICON = $0FFD0102;
      CdoPR_IDENTITY_DISPLAY = $3E00001E;
      CdoPR_IDENTITY_ENTRYID = $3E010102;
      CdoPR_IDENTITY_SEARCH_KEY = $3E050102;
      CdoPR_IMPLICIT_CONVERSION_PROHIBITED = $0016000B;
      CdoPR_IMPORTANCE = $00170003;
      CdoPR_INCOMPLETE_COPY = $0035000B;
      CdoPR_INITIAL_DETAILS_PANE = $3F080003;
      CdoPR_INITIALS = $3A0A001E;
      CdoPR_INSTANCE_KEY = $0FF60102;
      CdoPR_INTERNET_APPROVED = $1030001E;
      CdoPR_INTERNET_ARTICLE_NUMBER = $0E230003;
      CdoPR_INTERNET_CONTROL = $1031001E;
      CdoPR_INTERNET_DISTRIBUTION = $1032001E;
      CdoPR_INTERNET_FOLLOWUP_TO = $1033001E;
      CdoPR_INTERNET_LINES = $10340003;
      CdoPR_INTERNET_MESSAGE_ID = $1035001E;
      CdoPR_INTERNET_NEWSGROUPS = $1036001E;
      CdoPR_INTERNET_NNTP_PATH = $1038001E;
      CdoPR_INTERNET_ORGANIZATION = $1037001E;
      CdoPR_INTERNET_PRECEDENCE = $1041001E;
      CdoPR_INTERNET_REFERENCES = $1039001E;
      CdoPR_IPM_ID = $00180102;
      CdoPR_IPM_OUTBOX_ENTRYID = $35E20102;
      CdoPR_IPM_OUTBOX_SEARCH_KEY = $34110102;
      CdoPR_IPM_RETURN_REQUESTED = $0C02000B;
      CdoPR_IPM_SENTMAIL_ENTRYID = $35E40102;
      CdoPR_IPM_SENTMAIL_SEARCH_KEY = $34130102;
      CdoPR_IPM_SUBTREE_ENTRYID = $35E00102;
      CdoPR_IPM_SUBTREE_SEARCH_KEY = $34100102;
      CdoPR_IPM_WASTEBASKET_ENTRYID = $35E30102;
      CdoPR_IPM_WASTEBASKET_SEARCH_KEY = $34120102;
      CdoPR_ISDN_NUMBER = $3A2D001E;
      CdoPR_KEYWORD = $3A0B001E;
      CdoPR_LANGUAGE = $3A0C001E;
      CdoPR_LANGUAGES = $002F001E;
      CdoPR_LAST_MODIFICATION_TIME = $30080040;
      CdoPR_LATEST_DELIVERY_TIME = $00190040;
      CdoPR_LOCALITY = $3A27001E;
      CdoPR_LOCATION = $3A0D001E;
      CdoPR_MAIL_PERMISSION = $3A0E000B;
      CdoPR_MANAGER_NAME = $3A4E001E;
      CdoPR_MAPPING_SIGNATURE = $0FF80102;
      CdoPR_MDB_PROVIDER = $34140102;
      CdoPR_MESSAGE_ATTACHMENTS = $0E13000D;
      CdoPR_MESSAGE_CC_ME = $0058000B;
      CdoPR_MESSAGE_CLASS = $001A001E;
      CdoPR_MESSAGE_DELIVERY_ID = $001B0102;
      CdoPR_MESSAGE_DELIVERY_TIME = $0E060040;
      CdoPR_MESSAGE_DOWNLOAD_TIME = $0E180003;
      CdoPR_MESSAGE_FLAGS = $0E070003;
      CdoPR_MESSAGE_RECIP_ME = $0059000B;
      CdoPR_MESSAGE_RECIPIENTS = $0E12000D;
      CdoPR_MESSAGE_SECURITY_LABEL = $001E0102;
      CdoPR_MESSAGE_SIZE = $0E080003;
      CdoPR_MESSAGE_SUBMISSION_ID = $00470102;
      CdoPR_MESSAGE_TO_ME = $0057000B;
      CdoPR_MESSAGE_TOKEN = $0C030102;
      CdoPR_MHS_COMMON_NAME = $3A0F001E;
      CdoPR_MIDDLE_NAME = $3A44001E;
      CdoPR_MINI_ICON = $0FFC0102;
      CdoPR_MOBILE_TELEPHONE_NUMBER = $3A1C001E;
      CdoPR_MODIFY_VERSION = $0E1A0014;
      CdoPR_MSG_STATUS = $0E170003;
      CdoPR_NDR_DIAG_CODE = $0C050003;
      CdoPR_NDR_REASON_CODE = $0C040003;
      CdoPR_NEWSGROUP_NAME = $0E24001E;
      CdoPR_NICKNAME = $3A4F001E;
      CdoPR_NNTP_XREF = $1040001E;
      CdoPR_NON_RECEIPT_NOTIFICATION_REQUESTED = $0C06000B;
      CdoPR_NON_RECEIPT_REASON = $003E0003;
      CdoPR_NORMALIZED_SUBJECT = $0E1D001E;
      CdoPR_OBJECT_TYPE = $0FFE0003;
      CdoPR_OBSOLETED_IPMS = $001F0102;
      CdoPR_OFFICE_LOCATION = $3A19001E;
      CdoPR_OFFICE_TELEPHONE_NUMBER = $3A08001E;
      CdoPR_OFFICE2_TELEPHONE_NUMBER = $3A1B001E;
      CdoPR_ORGANIZATIONAL_ID_NUMBER = $3A10001E;
      CdoPR_ORIG_MESSAGE_CLASS = $004B001E;
      CdoPR_ORIGIN_CHECK = $00270102;
      CdoPR_ORIGINAL_AUTHOR_ADDRTYPE = $0079001E;
      CdoPR_ORIGINAL_AUTHOR_EMAIL_ADDRESS = $007A001E;
      CdoPR_ORIGINAL_AUTHOR_ENTRYID = $004C0102;
      CdoPR_ORIGINAL_AUTHOR_NAME = $004D001E;
      CdoPR_ORIGINAL_AUTHOR_SEARCH_KEY = $00560102;
      CdoPR_ORIGINAL_DELIVERY_TIME = $00550040;
      CdoPR_ORIGINAL_DISPLAY_BCC = $0072001E;
      CdoPR_ORIGINAL_DISPLAY_CC = $0073001E;
      CdoPR_ORIGINAL_DISPLAY_NAME = $3A13001E;
      CdoPR_ORIGINAL_DISPLAY_TO = $0074001E;
      CdoPR_ORIGINAL_EITS = $00210102;
      CdoPR_ORIGINAL_ENTRYID = $3A120102;
      CdoPR_ORIGINAL_SEARCH_KEY = $3A140102;
      CdoPR_ORIGINAL_SENDER_ADDRTYPE = $0066001E;
      CdoPR_ORIGINAL_SENDER_EMAIL_ADDRESS = $0067001E;
      CdoPR_ORIGINAL_SENDER_ENTRYID = $005B0102;
      CdoPR_ORIGINAL_SENDER_NAME = $005A001E;
      CdoPR_ORIGINAL_SENDER_SEARCH_KEY = $005C0102;
      CdoPR_ORIGINAL_SENSITIVITY = $002E0003;
      CdoPR_ORIGINAL_SENT_REPRESENTING_ADDRTYPE = $0068001E;
      CdoPR_ORIGINAL_SENT_REPRESENTING_EMAIL_ADDR = $0069001E;
      CdoPR_ORIGINAL_SENT_REPRESENTING_ENTRYID = $005E0102;
      CdoPR_ORIGINAL_SENT_REPRESENTING_NAME = $005D001E;
      CdoPR_ORIGINAL_SENT_REPRESENTING_SEARCH_KEY = $005F0102;
      CdoPR_ORIGINAL_SUBJECT = $0049001E;
      CdoPR_ORIGINAL_SUBMIT_TIME = $004E0040;
      CdoPR_ORIGINALLY_INTENDED_RECIP_ADDRTYPE = $007B001E;
      CdoPR_ORIGINALLY_INTENDED_RECIP_EMAIL_ADDR = $007C001E;
      CdoPR_ORIGINALLY_INTENDED_RECIP_ENTRYID = $10120102;
      CdoPR_ORIGINALLY_INTENDED_RECIPIENT_NAME = $00200102;
      CdoPR_ORIGINATING_MTA_CERTIFICATE = $0E250102;
      CdoPR_ORIGINATOR_AND_DL_EXPANSION_HISTORY = $10020102;
      CdoPR_ORIGINATOR_CERTIFICATE = $00220102;
      CdoPR_ORIGINATOR_DELIVERY_REPORT_REQUESTED = $0023000B;
      CdoPR_ORIGINATOR_NON_DELIVERY_REPORT_REQ = $0C08000B;
      CdoPR_ORIGINATOR_REQUESTED_ALTERNATE_RECIP = $0C090102;
      CdoPR_ORIGINATOR_RETURN_ADDRESS = $00240102;
      CdoPR_OTHER_ADDRESS_CITY = $3A5F001E;
      CdoPR_OTHER_ADDRESS_COUNTRY = $3A60001E;
      CdoPR_OTHER_ADDRESS_POST_OFFICE_BOX = $3A64001E;
      CdoPR_OTHER_ADDRESS_POSTAL_CODE = $3A61001E;
      CdoPR_OTHER_ADDRESS_STATE_OR_PROVINCE = $3A62001E;
      CdoPR_OTHER_ADDRESS_STREET = $3A63001E;
      CdoPR_OTHER_TELEPHONE_NUMBER = $3A1F001E;
      CdoPR_OWN_STORE_ENTRYID = $3E060102;
      CdoPR_OWNER_APPT_ID = $00620003;
      CdoPR_PAGER_TELEPHONE_NUMBER = $3A21001E;
      CdoPR_PARENT_DISPLAY = $0E05001E;
      CdoPR_PARENT_ENTRYID = $0E090102;
      CdoPR_PARENT_KEY = $00250102;
      CdoPR_PERSONAL_HOME_PAGE = $3A50001E;
      CdoPR_PHYSICAL_DELIVERY_BUREAU_FAX_DELIVERY = $0C0A000B;
      CdoPR_PHYSICAL_DELIVERY_MODE = $0C0B0003;
      CdoPR_PHYSICAL_DELIVERY_REPORT_REQUEST = $0C0C0003;
      CdoPR_PHYSICAL_FORWARDING_ADDRESS = $0C0D0102;
      CdoPR_PHYSICAL_FORWARDING_ADDRESS_REQUESTED = $0C0E000B;
      CdoPR_PHYSICAL_FORWARDING_PROHIBITED = $0C0F000B;
      CdoPR_PHYSICAL_RENDITION_ATTRIBUTES = $0C100102;
      CdoPR_POST_FOLDER_ENTRIES = $103B0102;
      CdoPR_POST_FOLDER_NAMES = $103C001E;
      CdoPR_POST_OFFICE_BOX = $3A2B001E;
      CdoPR_POST_REPLY_DENIED = $103F0102;
      CdoPR_POST_REPLY_FOLDER_ENTRIES = $103D0102;
      CdoPR_POST_REPLY_FOLDER_NAMES = $103E001E;
      CdoPR_POSTAL_ADDRESS = $3A15001E;
      CdoPR_POSTAL_CODE = $3A2A001E;
      CdoPR_PREFERRED_BY_NAME = $3A47001E;
      CdoPR_PREPROCESS = $0E22000B;
      CdoPR_PRIMARY_CAPABILITY = $39040102;
      CdoPR_PRIMARY_FAX_NUMBER = $3A23001E;
      CdoPR_PRIMARY_TELEPHONE_NUMBER = $3A1A001E;
      CdoPR_PRIORITY = $00260003;
      CdoPR_PROFESSION = $3A46001E;
      CdoPR_PROFILE_NAME = $3D12001E;
      CdoPR_PROOF_OF_DELIVERY = $0C110102;
      CdoPR_PROOF_OF_DELIVERY_REQUESTED = $0C12000B;
      CdoPR_PROOF_OF_SUBMISSION = $0E260102;
      CdoPR_PROOF_OF_SUBMISSION_REQUESTED = $0028000B;
      CdoPR_PROVIDER_DISPLAY = $3006001E;
      CdoPR_PROVIDER_DLL_NAME = $300A001E;
      CdoPR_PROVIDER_ORDINAL = $300D0003;
      CdoPR_PROVIDER_SUBMIT_TIME = $00480040;
      CdoPR_PROVIDER_UID = $300C0102;
      CdoPR_RADIO_TELEPHONE_NUMBER = $3A1D001E;
      CdoPR_RCVD_REPRESENTING_ADDRTYPE = $0077001E;
      CdoPR_RCVD_REPRESENTING_EMAIL_ADDRESS = $0078001E;
      CdoPR_RCVD_REPRESENTING_ENTRYID = $00430102;
      CdoPR_RCVD_REPRESENTING_NAME = $0044001E;
      CdoPR_RCVD_REPRESENTING_SEARCH_KEY = $00520102;
      CdoPR_READ_RECEIPT_ENTRYID = $00460102;
      CdoPR_READ_RECEIPT_REQUESTED = $0029000B;
      CdoPR_READ_RECEIPT_SEARCH_KEY = $00530102;
      CdoPR_RECEIPT_TIME = $002A0040;
      CdoPR_RECEIVE_FOLDER_SETTINGS = $3415000D;
      CdoPR_RECEIVED_BY_ADDRTYPE = $0075001E;
      CdoPR_RECEIVED_BY_EMAIL_ADDRESS = $0076001E;
      CdoPR_RECEIVED_BY_ENTRYID = $003F0102;
      CdoPR_RECEIVED_BY_NAME = $0040001E;
      CdoPR_RECEIVED_BY_SEARCH_KEY = $00510102;
      CdoPR_RECIPIENT_CERTIFICATE = $0C130102;
      CdoPR_RECIPIENT_NUMBER_FOR_ADVICE = $0C14001E;
      CdoPR_RECIPIENT_REASSIGNMENT_PROHIBITED = $002B000B;
      CdoPR_RECIPIENT_STATUS = $0E150003;
      CdoPR_RECIPIENT_TYPE = $0C150003;
      CdoPR_RECORD_KEY = $0FF90102;
      CdoPR_REDIRECTION_HISTORY = $002C0102;
      CdoPR_REFERRED_BY_NAME = $3A47001E;
      CdoPR_REGISTERED_MAIL_TYPE = $0C160003;
      CdoPR_RELATED_IPMS = $002D0102;
      CdoPR_REMOTE_PROGRESS = $3E0B0003;
      CdoPR_REMOTE_PROGRESS_TEXT = $3E0C001E;
      CdoPR_REMOTE_VALIDATE_OK = $3E0D000B;
      CdoPR_RENDERING_POSITION = $370B0003;
      CdoPR_REPLY_RECIPIENT_ENTRIES = $004F0102;
      CdoPR_REPLY_RECIPIENT_NAMES = $0050001E;
      CdoPR_REPLY_REQUESTED = $0C17000B;
      CdoPR_REPLY_TIME = $00300040;
      CdoPR_REPORT_ENTRYID = $00450102;
      CdoPR_REPORT_NAME = $003A001E;
      CdoPR_REPORT_SEARCH_KEY = $00540102;
      CdoPR_REPORT_TAG = $00310102;
      CdoPR_REPORT_TEXT = $1001001E;
      CdoPR_REPORT_TIME = $00320040;
      CdoPR_REPORTING_DL_NAME = $10030102;
      CdoPR_REPORTING_MTA_CERTIFICATE = $10040102;
      CdoPR_REQUESTED_DELIVERY_METHOD = $0C180003;
      CdoPR_RESOURCE_FLAGS = $30090003;
      CdoPR_RESOURCE_METHODS = $3E020003;
      CdoPR_RESOURCE_PATH = $3E07001E;
      CdoPR_RESOURCE_TYPE = $3E030003;
      CdoPR_RESPONSE_REQUESTED = $0063000B;
      CdoPR_RESPONSIBILITY = $0E0F000B;
      CdoPR_RETURNED_IPM = $0033000B;
      CdoPR_ROW_TYPE = $0FF50003;
      CdoPR_ROWID = $30000003;
      CdoPR_RTF_COMPRESSED = $10090102;
      CdoPR_RTF_IN_SYNC = $0E1F000B;
      CdoPR_RTF_SYNC_BODY_COUNT = $10070003;
      CdoPR_RTF_SYNC_BODY_CRC = $10060003;
      CdoPR_RTF_SYNC_BODY_TAG = $1008001E;
      CdoPR_RTF_SYNC_PREFIX_COUNT = $10100003;
      CdoPR_RTF_SYNC_TRAILING_COUNT = $10110003;
      CdoPR_SEARCH = $3607000D;
      CdoPR_SEARCH_KEY = $300B0102;
      CdoPR_SECURITY = $00340003;
      CdoPR_SELECTABLE = $3609000B;
      CdoPR_SEND_INTERNET_ENCODING = $3A710003;
      CdoPR_SEND_RICH_INFO = $3A40000B;
      CdoPR_SENDER_ADDRTYPE = $0C1E001E;
      CdoPR_SENDER_EMAIL_ADDRESS = $0C1F001E;
      CdoPR_SENDER_ENTRYID = $0C190102;
      CdoPR_SENDER_NAME = $0C1A001E;
      CdoPR_SENDER_SEARCH_KEY = $0C1D0102;
      CdoPR_SENSITIVITY = $00360003;
      CdoPR_SENT_REPRESENTING_ADDRTYPE = $0064001E;
      CdoPR_SENT_REPRESENTING_EMAIL_ADDRESS = $0065001E;
      CdoPR_SENT_REPRESENTING_ENTRYID = $00410102;
      CdoPR_SENT_REPRESENTING_NAME = $0042001E;
      CdoPR_SENT_REPRESENTING_SEARCH_KEY = $003B0102;
      CdoPR_SENTMAIL_ENTRYID = $0E0A0102;
      CdoPR_SERVICE_DELETE_FILES = $3D10101E;
      CdoPR_SERVICE_DLL_NAME = $3D0A001E;
      CdoPR_SERVICE_ENTRY_NAME = $3D0B001E;
      CdoPR_SERVICE_EXTRA_UIDS = $3D0D0102;
      CdoPR_SERVICE_NAME = $3D09001E;
      CdoPR_SERVICE_SUPPORT_FILES = $3D0F101E;
      CdoPR_SERVICE_UID = $3D0C0102;
      CdoPR_SERVICES = $3D0E0102;
      CdoPR_SPOOLER_STATUS = $0E100003;
      CdoPR_SPOUSE_NAME = $3A48001E;
      CdoPR_START_DATE = $00600040;
      CdoPR_STATE_OR_PROVINCE = $3A28001E;
      CdoPR_STATUS = $360B0003;
      CdoPR_STATUS_CODE = $3E040003;
      CdoPR_STATUS_STRING = $3E08001E;
      CdoPR_STORE_ENTRYID = $0FFB0102;
      CdoPR_STORE_PROVIDERS = $3D000102;
      CdoPR_STORE_RECORD_KEY = $0FFA0102;
      CdoPR_STORE_STATE = $340E0003;
      CdoPR_STORE_SUPPORT_MASK = $340D0003;
      CdoPR_STREET_ADDRESS = $3A29001E;
      CdoPR_SUBFOLDERS = $360A000B;
      CdoPR_SUBJECT = $0037001E;
      CdoPR_SUBJECT_IPM = $00380102;
      CdoPR_SUBJECT_PREFIX = $003D001E;
      CdoPR_SUBMIT_FLAGS = $0E140003;
      CdoPR_SUPERSEDES = $103A001E;
      CdoPR_SUPPLEMENTARY_INFO = $0C1B001E;
      CdoPR_SURNAME = $3A11001E;
      CdoPR_TELEX_NUMBER = $3A2C001E;
      CdoPR_TEMPLATEID = $39020102;
      CdoPR_TITLE = $3A17001E;
      CdoPR_TNEF_CORRELATION_KEY = $007F0102;
      CdoPR_TRANSMITABLE_DISPLAY_NAME = $3A20001E;
      CdoPR_TRANSPORT_KEY = $0E160003;
      CdoPR_TRANSPORT_MESSAGE_HEADERS = $007D001E;
      CdoPR_TRANSPORT_PROVIDERS = $3D020102;
      CdoPR_TRANSPORT_STATUS = $0E110003;
      CdoPR_TTYTDD_PHONE_NUMBER = $3A4B001E;
      CdoPR_TYPE_OF_MTS_USER = $0C1C0003;
      CdoPR_USER_CERTIFICATE = $3A220102;
      CdoPR_USER_X509_CERTIFICATE = $3A701102;
      CdoPR_VALID_FOLDER_MASK = $35DF0003;
      CdoPR_VIEWS_ENTRYID = $35E50102;
      CdoPR_WEDDING_ANNIVERSARY = $3A410040;
      CdoPR_X400_CONTENT_TYPE = $003C0102;
      CdoPR_X400_DEFERRED_DELIVERY_CANCEL = $3E09000B;
      CdoPR_XPOS = $3F050003;
      CdoPR_YPOS = $3F060003;
     
      // General
      PR_IPM_PUBLIC_FOLDERS_ENTRYID = $66310102;
      CdoDefaultFolderCalendar = 0;
      CdoDefaultFolderContacts = 5;
      CdoDefaultFolderDeletedItems = 4;
      CdoDefaultFolderInbox = 1;
      CdoDefaultFolderJournal = 6;
      CdoDefaultFolderNotes = 7;
      CdoDefaultFolderOutbox = 2;
      CdoDefaultFolderSentItems = 3;
      CdoDefaultFolderTasks = 8;
     
      // Message Recipients
      CdoTo = 1;
      CdoCc = 2;
      CdoBcc = 3;
     
      // Attachment Types
      CdoFileData = 1;
      CdoFileLink = 2;
      CdoOLE = 3;
      CdoEmbeddedMessage = 4;
     
      // AddressEntry DisplayType
      CdoUser = 0; //        A local messaging user.
      CdoDistList = 1; //        A public distribution list.
      CdoForum = 2; //        A forum, such as a bulletin board or a public folder.
      CdoAgent = 3; //        An automated agent, such as Quote-of-the-Day.
      CdoOrganization = 4;
      //        A special address entry defined for large groups, such as a helpdesk.
      CdoPrivateDistList = 5; //        A private, personally administered distribution list.
      CdoRemoteUser = 6; //        A messaging user in a remote messaging system.
     
      // Error Codes
      CdoE_OK = 0;
      CdoE_ACCOUNT_DISABLED = $80040124;
      CdoE_AMBIGUOUS_RECIP = $80040700;
      CdoE_BAD_CHARWIDTH = $80040103;
      CdoE_BAD_COLUMN = $80040118;
      CdoE_BAD_VALUE = $80040301;
      CdoE_BUSY = $8004010B;
      CdoE_CALL_FAILED = $80004005;
      CdoE_CANCEL = $80040501;
      CdoE_COLLISION = $80040604;
      CdoE_COMPUTED = $8004011A;
      CdoE_CORRUPT_DATA = $8004011B;
      CdoE_CORRUPT_STORE = $80040600;
      CdoE_DECLINE_COPY = $80040306;
      CdoE_DISK_ERROR = $80040116;
      CdoE_END_OF_SESSION = $80040200;
      CdoE_EXTENDED_ERROR = $80040119;
      CdoE_FAILONEPROVIDER = $8004011D;
      CdoE_FOLDER_CYCLE = $8004060B;
      CdoE_HAS_FOLDERS = $80040609;
      CdoE_HAS_MESSAGES = $8004060A;
      CdoE_INTERFACE_NOT_SUPPORTED = $80004002;
      CdoE_INVALID_ACCESS_TIME = $80040123;
      CdoE_INVALID_BOOKMARK = $80040405;
      CdoE_INVALID_ENTRYID = $80040107;
      CdoE_INVALID_OBJECT = $80040108;
      CdoE_INVALID_PARAMETER = $80070057;
      CdoE_INVALID_TYPE = $80040302;
      CdoE_INVALID_WORKSTATION_ACCOUNT = $80040122;
      CdoE_LOGON_FAILED = $80040111;
      CdoE_MISSING_REQUIRED_COLUMN = $80040202;
      CdoE_NETWORK_ERROR = $80040115;
      CdoE_NO_ACCESS = $80070005;
      CdoE_NO_RECIPIENTS = $80040607;
      CdoE_NO_SUPPORT = $80040102;
      CdoE_NO_SUPPRESS = $80040602;
      CdoE_NON_STANDARD = $80040606;
      CdoE_NOT_ENOUGH_DISK = $8004010D;
      CdoE_NOT_ENOUGH_MEMORY = $8007000E;
      CdoE_NOT_ENOUGH_RESOURCES = $8004010E;
      CdoE_NOT_FOUND = $8004010F;
      CdoE_NOT_IN_QUEUE = $80040601;
      CdoE_NOT_INITIALIZED = $80040605;
      CdoE_NOT_ME = $80040502;
      CdoE_OBJECT_CHANGED = $80040109;
      CdoE_OBJECT_DELETED = $8004010A;
      CdoE_PASSWORD_CHANGE_REQUIRED = $80040120;
      CdoE_PASSWORD_EXPIRED = $80040121;
      CdoE_SESSION_LIMIT = $80040112;
      CdoE_STRING_TOO_LONG = $80040105;
      CdoE_SUBMITTED = $80040608;
      CdoE_TABLE_EMPTY = $80040402;
      CdoE_TABLE_TOO_BIG = $80040403;
      CdoE_TIMEOUT = $80040401;
      CdoE_TOO_BIG = $80040305;
      CdoE_TOO_COMPLEX = $80040117;
      CdoE_TYPE_NO_SUPPORT = $80040303;
      CdoE_UNABLE_TO_ABORT = $80040114;
      CdoE_UNABLE_TO_COMPLETE = $80040400;
      CdoE_UNCONFIGURED = $8004011C;
      CdoE_UNEXPECTED_ID = $80040307;
      CdoE_UNEXPECTED_TYPE = $80040304;
      CdoE_UNKNOWN_CPID = $8004011E;
      CdoE_UNKNOWN_ENTRYID = $80040201;
      CdoE_UNKNOWN_FLAGS = $80040106;
      CdoE_UNKNOWN_LCID = $8004011F;
      CdoE_USER_CANCEL = $80040113;
      CdoE_VERSION = $80040110;
      CdoE_WAIT = $80040500;
      CdoW_APPROX_COUNT = $00040482;
      CdoW_CANCEL_MESSAGE = $00040580;
      CdoW_ERRORS_RETURNED = $00040380;
      CdoW_NO_SERVICE = $00040203;
      CdoW_PARTIAL_COMPLETION = $00040680;
      CdoW_POSITION_CHANGED = $00040481;
     
    type
      TOleVarPtr = ^OleVariant;
     
      TCdoMapiSession = class(TObject)
      private
        FImpersonated: boolean;
        FLastErrorCode: DWORD;
        FMyName,
          FMyEMailAddress,
          FLastError: string;
        FCurrentUser,
          FOleGlobalAddressList,
          FOleDeletedItems,
          FOleOutBox, FOleSentItems,
          FOleInbox, FOleContacts,
          FOleSession: OleVariant;
        FConnected: boolean;
        function GetFVersion: string;
      protected
        procedure SetOleFolders;
      public
        // System
        constructor Create; overload;
        constructor Create(const Profile: string); overload;
        constructor Create(const Profile: string;
          const UserName: string;
          const Domain: string;
          const Password: string); overload;
        destructor Destroy; override;
     
        // User
        function LoadAddressList(StringList: TStrings): boolean;
        function LoadObjectList(const FolderOle: OleVariant; List: TList): boolean;
        function LoadEMailTree(TV: TTreeView; Expand1stLevel: boolean = false;
          SubjectMask: string = ''): boolean;
        function LoadContactList(const FolderOle: OleVariant;
          Items: TStrings): boolean; overload;
        function LoadContactList(const FolderName: string;
          Items: TStrings): boolean; overload;
        procedure ShowContactDetails(Contact: OleVariant);
     
        function First(const FolderOle: OleVariant; out ItemOle: OleVariant): boolean;
        function Last(const FolderOle: OleVariant; out ItemOle: OleVariant): boolean;
        function Next(const FolderOle: OleVariant; out ItemOle: OleVariant): boolean;
        function Prior(const FolderOle: OleVariant; out ItemOle: OleVariant): boolean;
        function AsString(const ItemOle: Olevariant; const FieldIdConstant: DWORD):
          string;
     
        // Properties
        property CurrentUser: OleVariant read FCurrentUser;
        property Connected: boolean read FConnected;
        property LastErrorMess: string read FlastError;
        property LastErrorCode: DWORD read FlastErrorCode;
        property InBox: OleVariant read FOleInBox;
        property OutBox: OleVariant read FOleOutBox;
        property DeletedItems: Olevariant read FOleDeletedItems;
        property SentItems: Olevariant read FOleSentItems;
        property GlobalAddressList: Olevariant read FOleGlobalAddressList;
        property Contacts: Olevariant read FOleContacts;
        property Session: OleVariant read FOleSession;
        property Version: string read GetFVersion;
        property MyName: string read FMyName;
        property MyEMailAddress: string read FMyEMailAddress;
      end;
     
      // Function Prototypes
    function CdoNothing(Obj: OleVariant): boolean;
    function CdoDefaultProfile: string;
    procedure CdoDisposeList(WorkList: TList);
    procedure CdoDisposeObjects(WorkStrings: TStrings);
    procedure CdoDisposeNodes(WorkData: TTreeNodes);
     
    function VarNothing: IDispatch;
     
    // -----------------------------------------------------------------------------
    implementation
     
    // ===================================
    // Emulate VB function IS NOTHING
    // ===================================
     
    function CdoNothing(Obj: OleVariant): boolean;
    begin
      Result := IDispatch(Obj) = nil;
    end;
     
    // ============================================
    // Emulate VB function VarX := Nothing
    // ============================================
     
    function VarNothing: IDispatch;
    var
      Retvar: IDispatch;
    begin
      Retvar := nil;
      Result := Retvar;
    end;
     
    // ============================================
    // Get Default Message profile from registry
    // ============================================
     
    function CdoDefaultProfile: string;
    var
      WinReg: TRegistry;
      Retvar: string;
    begin
      Retvar := '';
      WinReg := TRegistry.Create;
     
      if
        WinReg.OpenKey('\Software\Microsoft\Windows NT\CurrentVersion\Windows Messaging Subsystem\Profiles', false) then
      begin
        Retvar := WinReg.ReadString('DefaultProfile');
        WinReg.CloseKey;
      end;
     
      WinReg.Free;
      Result := Retvar;
    end;
     
    // =================================================
    // Disposes of any memory allocations in a TList
    // =================================================
     
    procedure CdoDisposeList(WorkList: TList);
    var
      i: integer;
    begin
      if WorkList <> nil then
        for i := 0 to WorkList.Count - 1 do
          if WorkList[i] <> nil then
            dispose(WorkList[i]);
    end;
     
    // ====================================================
    // Disposes of any memory allocations in a TStringList
    // ====================================================
     
    procedure CdoDisposeObjects(WorkStrings: TStrings);
    var
      i: integer;
    begin
      if WorkStrings <> nil then
        for i := 0 to WorkStrings.Count - 1 do
          if WorkStrings.Objects[i] <> nil then
            dispose(TOleVarPtr(WorkStrings.Objects[i]));
    end;
     
    // ====================================================
    // Disposes of any memory allocations in a TTreeView
    // ====================================================
     
    procedure CdoDisposeNodes(WorkData: TTreeNodes);
    var
      i: integer;
      TN: TTreeNode;
    begin
      if WorkData <> nil then
      begin
        for i := 0 to WorkData.Count - 1 do
        begin
          TN := WorkData[i];
          if TN.Data <> nil then
            dispose(TOleVarPtr(TN.Data));
        end;
      end;
    end;
     
    // -----------------------------------------------------------------------------
    // TCdoMapiSession
    // -----------------------------------------------------------------------------
     
    // ================
    // Default Profile
    // ================
     
    constructor TCdoMapiSession.Create;
    begin
      FImpersonated := false;
      FLastError := '';
      FLastErrorCode := CdoE_OK;
      try
        FOleSession := CreateOleObject('MAPI.Session');
        FOleSession.Logon(CdoDefaultProfile);
        SetOleFolders;
      except
        on E: Exception do
        begin
          FLastError := E.Message;
          FLastErrorCode := CdoE_LOGON_FAILED;
          FConnected := false;
        end;
      end;
    end;
     
    // ===========================
    // With Specified Profile
    // ===========================
     
    constructor TCdoMapiSession.Create(const Profile: string);
    begin
      FImpersonated := false;
      try
        FOleSession := CreateOleObject('MAPI.Session');
        FOleSession.Logon(Profile);
        SetOleFolders;
      except
        on E: Exception do
        begin
          FLastError := E.Message;
          FLastErrorCode := CdoE_LOGON_FAILED;
          FConnected := false;
        end;
      end;
    end;
     
    // ======================================================
    // Impersonate amother user and use specified profile
    // ======================================================
     
    constructor TCdoMapiSession.Create(const Profile: string;
      const UserName: string;
      const Domain: string;
      const Password: string);
    var
      SecurityH: THandle;
    begin
      FImpersonated := false;
      try
        LogonUser(PChar(UserName), PChar(Domain), PChar(Password),
          LOGON32_LOGON_SERVICE,
          LOGON32_PROVIDER_DEFAULT, SecurityH);
        FImpersonated := ImpersonateLoggedOnUser(SecurityH);
        FOleSession := CreateOleObject('MAPI.Session');
        FOleSession.Logon(Profile, Password, false, true);
        SetOleFolders;
      except
        on E: Exception do
        begin
          FLastError := E.Message;
          FLastErrorCode := CdoE_LOGON_FAILED;
          FConnected := false;
        end;
      end;
    end;
     
    // ======================
    // Free and Clean up
    // ======================
     
    destructor TCdoMapiSession.Destroy;
    begin
      if FConnected then
        FOleSession.LogOff;
      FCurrentUser := Unassigned;
      FOleGlobalAddressList := Unassigned;
      FOleSentItems := Unassigned;
      FOleContacts := Unassigned;
      FOleOutBox := Unassigned;
      FOleDeletedItems := Unassigned;
      FOleInBox := Unassigned;
      FOleSession := Unassigned;
      if FImpersonated then
        RevertToSelf;
      inherited Destroy;
    end;
     
    // =======================================================
    // Addition initialization called by Create() oveloads
    // =======================================================
     
    procedure TCdoMapiSession.SetOleFolders;
    begin
      try
        FOleGlobalAddressList :=
          FOleSession.AddressLists['Global Address List'].AddressEntries;
      except
        FOleGlobalAddressList := VarNothing;
      end;
     
      try
        FOleContacts := FOleSession.AddressLists['Contacts'].AddressEntries;
      except
        FOleContacts := VarNothing;
      end;
     
      try
        FOleInBox := FOleSession.InBox.Messages;
      except
        FOleInBox := VarNothing;
      end;
     
      try
        FOleOutBox := FOleSession.OutBox.Messages;
      except
        FOleOutBox := VarNothing;
      end;
     
      try
        FOleDeletedItems :=
          FOleSession.GetDefaultFolder(CdoDefaultFolderDeletedItems).Messages;
      except
        FOleDeletedItems := VarNothing;
      end;
     
      try
        FOleSentItems := FOleSession.GetDefaultFolder(CdoDefaultFolderSentItems).Messages;
      except
        FOleSentItems := VarNothing;
      end;
     
      try
        FCurrentUser := FOleSession.CurrentUser;
        FMyName := FCurrentUser.Name;
      except
        FCurrentUser := VarNothing;
      end;
     
      FConnected := true;
      FMyEMailAddress := AsString(FCurrentUser, CdoPR_EMAIL_AT_ADDRESS);
    end;
     
    // ======================
    // Return CDO Version
    // ======================
     
    function TCdoMapiSession.GetFVersion: string;
    begin
      if FConnected then
        Result := FOleSession.Version
      else
        Result := 'Not Connected';
    end;
     
    // ========================================================
    // Fill a string list with all available address lists
    // ========================================================
     
    function TCdoMapiSession.LoadAddressList(StringList: TStrings): boolean;
    var
      Addr: OleVariant;
      i: integer;
      Retvar: boolean;
    begin
      Retvar := false;
     
      if FConnected then
      begin
        StringList.Clear;
        try
          Addr := FOleSession.AddressLists;
          for i := 1 to Addr.Count do
            StringList.Add(Addr.Item[i].Name);
          Retvar := true;
        except
          on E: Exception do
          begin
            FLastError := E.Message;
            FLastErrorCode := CdoE_NOT_FOUND;
          end;
        end;
     
        Addr := Unassigned;
      end;
     
      Result := Retvar;
    end;
     
    // =================================================
    // Iteration functions
    // =================================================
     
    function TCdoMapiSession.First(const FolderOle: OleVariant;
      out ItemOle: OleVariant): boolean;
    var
      Retvar: boolean;
    begin
      Retvar := true;
     
      if FConnected then
      begin
        try
          ItemOle := FolderOle.GetFirst;
          if CdoNothing(ItemOle) then
          begin
            Retvar := false;
          end;
        except
          on E: Exception do
          begin
            FLastError := E.Message;
            FLastErrorCode := CdoE_NOT_FOUND;
            Retvar := false;
          end;
        end;
      end
      else
        Retvar := false;
     
      Result := Retvar;
    end;
     
    function TCdoMapiSession.Last(const FolderOle: OleVariant;
      out ItemOle: OleVariant): boolean;
    var
      Retvar: boolean;
    begin
      Retvar := true;
     
      if FConnected then
      begin
        try
          ItemOle := FolderOle.GetLast;
          if CdoNothing(ItemOle) then
          begin
            Retvar := false;
          end;
        except
          on E: Exception do
          begin
            FLastError := E.Message;
            FLastErrorCode := CdoE_NOT_FOUND;
            Retvar := false;
          end;
        end;
      end
      else
        Retvar := false;
     
      Result := Retvar;
    end;
     
    function TCdoMapiSession.Next(const FolderOle: OleVariant;
      out ItemOle: OleVariant): boolean;
    var
      Retvar: boolean;
    begin
      Retvar := true;
     
      if FConnected then
      begin
        try
          ItemOle := FolderOle.GetNext;
          if CdoNothing(ItemOle) then
          begin
            Retvar := false;
          end;
        except
          on E: Exception do
          begin
            FLastError := E.Message;
            FLastErrorCode := CdoE_NOT_FOUND;
            Retvar := false;
          end;
        end;
      end
      else
        Retvar := false;
     
      Result := Retvar;
    end;
     
    function TCdoMapiSession.Prior(const FolderOle: OleVariant;
      out ItemOle: OleVariant): boolean;
    var
      Retvar: boolean;
    begin
      Retvar := true;
     
      if FConnected then
      begin
        try
          ItemOle := FolderOle.GetPrior;
          if CdoNothing(ItemOle) then
          begin
            Retvar := false;
          end;
        except
          on E: Exception do
          begin
            FLastError := E.Message;
            FLastErrorCode := CdoE_NOT_FOUND;
            Retvar := false;
          end;
        end;
      end
      else
        Retvar := false;
     
      Result := Retvar;
    end;
     
    // =========================
    // Field Get Routines
    // =========================
     
    function TCdoMapiSession.AsString(const ItemOle: Olevariant;
      const FieldIdConstant: DWORD): string;
    var
      Retvar: string;
    begin
      if FConnected then
      begin
        // Special case for EMail Address - Resolve to normal form
        if FieldIdConstant = CdoPR_EMAIL_AT_ADDRESS then
        begin
          try
            RetVar := ItemOle.Fields[CdoPR_EMAIL_AT_ADDRESS];
          except
            try
              Retvar := ItemOle.Fields[CdoPR_EMAIL_ADDRESS];
            except
              on E: Exception do
              begin
                FLastError := E.Message;
                FLastErrorCode := CdoE_INVALID_OBJECT;
                Retvar := '';
              end;
            end;
          end;
        end
        else
        begin
          try
            RetVar := ItemOle.Fields[FieldIdConstant];
          except
            on E: Exception do
            begin
              FLastError := E.Message;
              FLastErrorCode := CdoE_INVALID_OBJECT;
              Retvar := '';
            end;
          end;
        end;
      end
      else
        Retvar := '';
     
      Result := Retvar;
    end;
     
    // ================================================
    // Load EMail folders Messages into a TTreeView
    // Allocations in Nodes are freed at each call to
    // LoadEMailTree, but you are responsible to call
    // CdoDisposeNodes or dispose of the allocations
    // yourself at Application end
    // ================================================
     
    function TCdoMapiSession.LoadEMailTree(TV: TTreeView;
      Expand1stLevel: boolean = false;
      SubjectMask: string = ''): boolean;
    var
      DocPtr: TOleVarPtr;
      Item: OleVariant;
      TN, RN, XN: TTreeNode;
      Retvar,
        Images: boolean;
     
      procedure AddTree(const Name: string; Folder: Olevariant);
      begin
        if First(Folder, Item) then
        begin
          TN := TV.Items.AddChildObject(RN, Name, nil);
          if Images then
          begin
            TN.ImageIndex := 0;
            TN.SelectedIndex := 0;
          end;
     
          while true do
          begin
            if (SubjectMask = '') or (MatchesMask(Item.Subject, SubjectMask)) then
            begin
              New(DocPtr);
              DocPtr^ := Item;
              if Item.Subject = '' then
                XN := TV.Items.AddChildObject(TN, '<No Subject> - ' + Item.Sender.Name,
                  DocPtr)
              else
                XN := TV.Items.AddChildObject(TN, Item.Subject, DocPtr);
     
              if Images then
              begin
                XN.ImageIndex := 1;
                XN.SelectedIndex := 1;
              end;
            end;
     
            if not Next(Folder, Item) then
              break;
          end;
        end;
      end;
     
    begin
      Retvar := false;
     
      if FConnected then
      begin
        Screen.Cursor := crHourGlass;
        Application.ProcessMessages;
        CdoDisposeNodes(TV.Items);
        TV.Items.Clear;
        TV.Items.BeginUpdate;
        TN := nil;
        RN := nil;
        RN := TV.Items.AddObject(RN, 'Personal Folders', nil);
        Images := (TV.Images <> nil) and (TV.Images.Count >= 2);
        if Images then
        begin
          RN.ImageIndex := 0;
          RN.SelectedIndex := 0;
        end;
     
        try
          AddTree('Inbox', InBox);
          AddTree('Outbox', OutBox);
          AddTree('Sent Items', SentItems);
          AddTree('Deleted Items', DeletedItems);
          Retvar := true;
        except
          on E: Exception do
          begin
            FLastError := E.Message;
            FLastErrorCode := CdoE_CALL_FAILED;
          end;
        end;
     
        if Expand1stLevel then
          TV.Items[0].Expand(false);
        TV.Items.EndUpdate;
        Screen.Cursor := crDefault;
        Item := Unassigned;
        Screen.Cursor := crDefault;
      end;
     
      Result := Retvar;
    end;
     
    // =============================================================
    // Load Contact list into a TStringList
    // Allocations in Objects are freed at each call to
    // LoadEMailTree, but you are responsible to call
    // CdoDisposeObjects or dispose of the allocations yourself at
    // Application end.
    //
    // Format "[LastName FirstName]EMailAddress"
    // ===============================================================
     
    function TCdoMapiSession.LoadContactList(const FolderOle: OleVariant;
      Items: TStrings): boolean;
    var
      ContactPtr: TOleVarPtr;
      Contact: OleVariant;
      AddrType,
        FullName,
        LastName, FirstName, Email: string;
      Retvar: boolean;
    begin
      Retvar := false;
     
      if FConnected then
      begin
        Screen.Cursor := crHourGlass;
        Application.ProcessMessages;
        CdoDisposeObjects(Items);
        Items.Clear;
        Items.BeginUpdate;
     
        try
          if First(FolderOle, Contact) then
          begin
            while true do
            begin
              LastName := trim(AsString(Contact, CdoPR_SURNAME));
              FirstName := trim(AsString(Contact, CdoPR_GIVEN_NAME));
              EMail := AsString(Contact, CdoPR_EMAIL_AT_ADDRESS);
              AddrType := AsString(Contact, CdoPR_ADDRTYPE);
     
              if (EMail <> '') and (AddrType <> 'FAX') then
              begin
                New(ContactPtr);
                ContactPtr^ := Contact;
                FullName := trim(LastName + ' ' + FirstName);
                Items.AddObject('[' + FullName + ']' + EMail, TObject(ContactPtr));
              end;
     
              if not Next(FolderOle, Contact) then
                break;
            end;
     
            Retvar := true;
          end;
        except
          on E: Exception do
          begin
            FLastError := E.Message;
            FLastErrorCode := CdoE_CALL_FAILED;
          end;
        end;
     
        Items.EndUpdate;
        Contact := Unassigned;
        Screen.Cursor := crDefault;
      end;
     
      Result := Retvar;
    end;
     
    function TCdoMapiSession.LoadContactList(const FolderName: string;
      Items: TStrings): boolean;
    var
      Contacts: OleVariant;
      Retvar: boolean;
    begin
      Retvar := false;
     
      if FConnected then
      begin
        try
          Contacts := FOleSession.AddressLists[FolderName].AddressEntries;
          if not CdoNothing(Contacts) then
          begin
            Retvar := LoadContactList(Contacts, Items);
          end;
          Contacts := Unassigned;
        except
          on E: Exception do
          begin
            CdoDisposeObjects(Items);
            Items.Clear;
            FLastError := E.Message;
            FLastErrorCode := CdoE_CALL_FAILED;
          end;
        end;
      end;
     
      Result := Retvar;
    end;
     
    // =============================================================
    // Load Folder list into a TList
    // Allocations in Objects are freed at each call to
    // LoadObjectList, but you are responsible to call
    // CdoDisposeList or dispose of the allocations yourself at
    // Application end.
    // ===============================================================
     
    function TCdoMapiSession.LoadObjectList(const FolderOle: OleVariant;
      List: TList): boolean;
    var
      ItemPtr: TOleVarPtr;
      Item: OleVariant;
      Retvar: boolean;
    begin
      Retvar := false;
     
      if FConnected then
      begin
        Screen.Cursor := crHourGlass;
        Application.ProcessMessages;
        CdoDisposeList(List);
        List.Clear;
     
        try
          if First(FolderOle, Item) then
          begin
            while true do
            begin
              New(ItemPtr);
              ItemPtr^ := Item;
              List.Add(ItemPtr);
     
              if not Next(FolderOle, Item) then
                break;
            end;
          end;
        except
          on E: Exception do
          begin
            CdoDisposeList(List);
            List.Clear;
            FLastError := E.Message;
            FLastErrorCode := CdoE_CALL_FAILED;
          end;
        end;
     
        Item := Unassigned;
        Screen.Cursor := crDefault;
      end;
     
      Result := Retvar;
    end;
     
    // =================================================================
    // The CDO method Details() gives an error if cancel is pressed
    // =================================================================
     
    procedure TCdoMapiSession.ShowContactDetails(Contact: OleVariant);
    begin
      if not CdoNothing(Contact) then
      try
        Contact.Details(Application.Handle);
      except
        // Not interested - either a dialog appears or not
      end;
    end;
     
    end.

