<!DOCTYPE html>
<html lang="en">

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no"/>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="apple-touch-icon" sizes="76x76" href="{$baseUrl}/views/images/logo-dark.png{$cache}">
  <link rel="icon" type="image/png" href="{$baseUrl}/views/images/favicon.png{$cache}">
  <title>{$title}</title>
  <link rel="stylesheet" type="text/css" href="{$baseUrl}/views/css/error.css{$cache}"/>
</head>

<body>
<main>
  <section>
      {if !isset($error)}
        <span>404</span>
        <p>
          The requested path could not be found visit:&nbsp;<a href="{$baseUrl}">Home Page</a>
        </p>
      {else}
        <span>{$error.code}</span>
        <p>
            {wordwrap($error.message, 80, '<br/>')}
          <br/> visit:&nbsp;
          <a href="{$error.gotoLink}">{$error.gotoName}</a>
        </p>
      {/if}
  </section>
</main>
</body>

</html>