# Task Target Dependencies

For a task that has more than one target (method) you can specify dependencies that will run, in the order specified, prior to your final target.  Specify task target dependencies as a comma-delimited list in a `depends` annotation on the target function itself.  There is no limit to how many target dependencies you can have, nor how deep they can nest. &#x20;

```javascript
component {

  function run() depends="runMeFirst" {
  }
  
  function runMeFirst() {
  }
  
}
```

Given the above Task Runner, typing

```bash
task run
```

would run the `runMeFirst()` and `run()` method in that order. &#x20;

Any parameters passed to the target will also be passed along to methods who are dependencies.  Don't forget, task CFCs are re-created every time they are executed as transients, so feel free to borrow the `variables` scope inside the CFC to share state between methods.
