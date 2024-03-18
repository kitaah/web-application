import React, { useState } from "react";
import "../../css/Articles.css";

const Article = ({ date, title, text }) => {
    const [expanded, setExpanded] = useState(false);

    const toggleExpand = () => {
        setExpanded(!expanded);
    };

    return (
        <div className="article">
            <div className="date">{date}</div>
            <h2 className="title">{title}</h2>
            <div className="textWrapper">
                <button className="toggle-btn" onClick={toggleExpand}>
                    {expanded ? "↓" : "→"}
                </button>
                <div className={`text ${expanded ? "expanded" : ""}`}>
                    {text}
                </div>
            </div>
        </div>
    );
};

const Articles = ({ resources }) => {
    return (
        <div className="resources flex flex-col items-center mt-5">
            {resources.map((resource, index) => (
                <Article
                    key={index}
                    date={resource.created_at}
                    title={resource.name}
                    text={resource.description}
                />
            ))}
        </div>
    );
};

{/*
const Articles = ({ articles }) => {
    return (
        <div className="articles">
            {articles.map((article, index) => (
                <Article
                    key={index}
                    date={article.date}
                    title={article.name}
                    text={article.text}
                />
            ))}
        </div>
    );
};
*/}

export default Articles;
