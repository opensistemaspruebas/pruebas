function getConfig(max, suffix) {
    return {
      strokeWidth: 1,
      easing: 'easeInOut',
      duration: 1400,
      color: '#004481',
      trailColor: '#F4F4F4',
      trailWidth: 1,
      text: {
        style: {
          color: '#121212',
          transform: null,
        },
        autoStyleContainer: false,
      },
      step: function (state, bar) {
        bar.setText('<div class="progressNumber">' +  Math.round(bar.value() * max * 10) / 10
        + '</div><div class="progressSuffix ml-xs">' + suffix + '</div>');
      },
    };
}

function getCircleConfig(max, color, trailColor, suffix, subColor, subtext) {
    return {
      strokeWidth: 4,
      easing: 'easeInOut',
      duration: 1400,
      color: color,
      trailColor: trailColor,
      trailWidth: 4,
      text: {
        autoStyleContainer: false,
      },
      step: function (state, circle) {
        circle.setText('<div class="circleNumber">' + Math.round(circle.value() * max * 10) / 10
        + '<label>' + suffix + '</label></div>' +
        '<div class="circleSubText ' + subColor + '">' + subtext + '</div>');
      },
    };
}

function setProgressBarLine(identifier, config, animate) {
  try {
      var bar = new ProgressBar.Line(identifier, config);
      bar.animate(animate);
  }
  catch (e) {
  }
}

function setProgressBarCircle (identifier, config, animate) {
  try {
      var circle = new ProgressBar.Circle(identifier, config);
      circle.animate(animate);
  }
  catch (e) {
  }
}
