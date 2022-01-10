const getArticleBackgroundColor = () => {
  const colors = [
    "violet",
    "salmon",
    "pink",
    "wheat",
    "lightblue",
    "lightgreen",
    "orange",
  ];

  return colors[Math.floor(Math.random() * colors.length)];
};
