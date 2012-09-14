<? echo '<?xml version="1.0" encoding="utf-8" ?>'; ?>
<? 
	$type = $user ? "Update" : "Add";
	$request = $user ? "Customer".$type."Request" : "Customer".$type."Request"; 
	$mode = $user ? ' Mode=""':'';
?>
<<?=$request?>> 
  <Version>1.1</Version> 
  <TransactionHeader> 
    <SenderID></SenderID> 
    <ReceiverID></ReceiverID> 
    <CountryCode></CountryCode> 
    <LoginID>YSG1</LoginID> 
    <Password>YSG1</Password> 
    <Company>YSG</Company> 
    <TransactionID></TransactionID> 
  </TransactionHeader> 
  <Defaults> 
    <BusinessUnit>UNITED KINGDOM</BusinessUnit> 
  </Defaults> 
  <Customer<?=$type?>> 
    <Sites Total="1"> 
    <Site <?=$mode?>> 
        <Name></Name> 
        <AccountNumber1></AccountNumber1> 
        <AccountNumber2></AccountNumber2> 
        <AccountNumber3></AccountNumber3> 
        <AccountNumber4></AccountNumber4> 
        <AccountNumber5></AccountNumber5> 
        <Address> 
          <Line1></Line1> 
          <Line2></Line2> 
          <Line3></Line3> 
          <Line4></Line4> 
          <Line5></Line5> 
          <PostCode></PostCode> 
          <Country></Country> 
        </Address> 
        <TelephoneNumber></TelephoneNumber> 
        <FaxNumber></FaxNumber> 
        <VATNumber></VATNumber> 
        <URL></URL> 
        <ID></ID> 
        <CRMBranch></CRMBranch> 
        <Contacts Total="1"> 
	<Contact <?=$mode?>>

	  <Title><?=$salutation?></Title> 
	  <Initials><?=$post['gg-reg-fname'][0]?></Initials> 
	  <Forename><?=$post['gg-reg-fname']?></Forename> 
	  <Surname><?=$post['gg-reg-lname']?></Surname> 
	  <FullName></FullName> 
	  <Salutation><?=$post['gg-reg-fname']?></Salutation> 
	  <EmailAddress><?=$post['gg-reg-email']?></EmailAddress> 
<? if($user){ ?>
<? } ?>
<LoginID><?=$user['username']?></LoginID>
	  <Password><?=$post['gg-reg-password']?></Password> 
            <AccountNumber1></AccountNumber1> 
            <AccountNumber2></AccountNumber2> 
            <AccountNumber3></AccountNumber3> 
            <AccountNumber4></AccountNumber4> 
            <AccountNumber5></AccountNumber5> 
            <Addresses Total="1"> 
	    <Address <?=$mode?>> 
                <SequenceNumber>1</SequenceNumber> 
                <Default>True</Default> 
                <Reference>Default Address</Reference> 
		<Line1><?=$post['gg-reg-add1']?></Line1> 
		<Line2><?=$post['gg-reg-add2']?></Line2> 
		<Line3><?=$post['gg-reg-county']?></Line3> 
                <Line4></Line4> 
                <Line5></Line5> 
		<PostCode><?=$post['gg-reg-pcode']?></PostCode> 
                <Country>United Kingdom</Country> 
              </Address> 
            </Addresses> 
            <Position></Position> 
	    <Gender><?=$post['gg-reg-gender']?></Gender> 
	    <TelephoneNumber1><?=$post['gg-reg-home-phone']?></TelephoneNumber1> 
	    <TelephoneNumber2><?=$post['gg-reg-daytime-phone']?></TelephoneNumber2> 
            <TelephoneNumber3></TelephoneNumber3> 
            <TelephoneNumber4></TelephoneNumber4> 
            <TelephoneNumber5></TelephoneNumber5> 
	    <DateOfBirth><?=$dob?></DateOfBirth> 
	    <ContactViaMail><?=$post['gg-reg-additional']?'N':'Y'?></ContactViaMail> 
            <HTMLNewsletter>N</HTMLNewsletter> 
            <Subscription1>N</Subscription1> 
            <Subscription2>N</Subscription2> 
            <Subscription3>N</Subscription3> 
            <MailFlag1>N</MailFlag1> 
            <ExternalId1>0</ExternalId1> 
            <ExternalId2>0</ExternalId2> 
            <MessagingID></MessagingID> 
            <Boolean1></Boolean1> 
            <Boolean2></Boolean2> 
            <Boolean3></Boolean3> 
            <Boolean4></Boolean4> 
            <Boolean5></Boolean5> 
            <ID></ID> 
            <RestrictedPaymentTypes Total=""> 
		    <PaymentType <?=$mode?>></PaymentType> 
	    </RestrictedPaymentTypes> 
<? //if($attributes) { ?>
	    <Attributes Total=""> 
		<Attribute Mode="Test"/>
<? foreach($attributes as $attribute) { ?>
<Attribute><?=$attribute?></Attribute> 
<? } ?>
	    </Attributes> 
<? //} ?>
            <LoyaltyPoints></LoyaltyPoints> 
            <IsLockedOut>False</IsLockedOut> 
            <CustomerPurchaseHistory>False</CustomerPurchaseHistory> 
          </Contact> 
        </Contacts> 
      </Site> 
    </Sites> 
  </Customer<?=$type?>> 
</<?=$request?>> 
