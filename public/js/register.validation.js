const rules = {
  email: {
    identifier: 'email',
    rules: [
      {
        type: 'email',
        prompt: 'Please use a valid email address'
      }
    ]
  },
  first_name: {
    identifier: 'first_name',
    rules: [
      {
        type: 'regExp[/^[a-zA-Z]{4,16}$/]',
        prompt: 'Please enter a 4-16 first name'
      },
    ]
  },
  last_name: {
    identifier: 'last_name',
    rules: [
      {
        type: 'regExp[/^[a-zA-Z]{4,16}$/]',
        prompt: 'Please enter a 4-16 last name'
      }
    ]
  },
  password: {
    identifier: 'password',
    rules: [
      {
        type: 'minLength[6]',
        prompt: 'Your password must be at least {ruleValue} characters'
      }
    ]
  }
}

jQuery(function () {
  // and here your code

  $('.ui.form.register').form({
    on: 'blur',
    fields: {
     email: rules.email,
     first_name: rules.first_name,
     last_name:rules.last_name,
     password:rules.password
    }
  });


  $('.ui.form.login').form({
    on: 'blur',
    fields: {
    email:rules.email,
    password:rules.password
    }
  });
});


 /* if ($('.ui.form').form('is valid')) {
  unused code
  }
  */

console.log("Script Loaded")