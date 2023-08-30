# Extending MailWizz API

## Query subscribers by date added

Example url

```sh
https://m.cashify.team/index.php/getsubscribersbydate?secret=[SECRET]&list_uid=[LIST_UID]&from_date=[FROM_DATE]&to_date=[TO_DATE]
```

All params are required

## Get multiple campaigns in one API call

```sh
https://m.cashify.team/index.php/getcampaignsbyuid?secret=[SECRET]&campaign_uid=[CAMPAIGN_UID]
```

All params are required:

secret -> string

campaign_uid -> array (make sure to encode it)