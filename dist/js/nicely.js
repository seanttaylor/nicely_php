console.log("Nicely v0.0.1");

const $ = document.querySelector.bind(document);

const createPostBtn = $("#create-post-btn");
const createPostInput = $("#create-post-input");
const addCommentInput = $("#comment-input");
const userIdHiddenInput = $("#user-id");
const userPostList = $("#user-post-list");

createPostBtn.addEventListener("click", onClickCreatePostButton);
userPostList.addEventListener("click", onClickLikeButton);
userPostList.addEventListener("keyup", onAddComment);

/**
 * Event handler for creating a new post
 * @param {Object} e - the HTML Event object 
 */
async function onClickCreatePostButton(e) {
    // See https://stackoverflow.com/questions/33439030/how-to-grab-data-using-fetch-api-post-method-in-php
    const formData = new FormData();
    formData.append("post-body", `${createPostInput.value}`);
    formData.append("rel", "create-post");
    formData.append("user-id", `${userIdHiddenInput.value}`);

    const response = await fetch("./src/client/post.php", {
        method: "POST",
        body: formData
    });

    const newPost = await response.text();
    userPostList.insertAdjacentHTML("afterbegin", newPost);
}

/**
 * Event handler for creating a new post; increments the associated Post's comment count in the UI
 * @param {Object} e - the HTML Event object 
 */
async function onAddComment(e) {
    if (e.target.classList.contains("comment-input") && e.keyCode === 13) {
        const commentStatsSelector = `[data-post-stats="${e.target.dataset.postId}"] span[data-comment-count]`;
        const formData = new FormData();

        formData.append("comment-body", e.target.value);
        formData.append("commenter-id", e.target.dataset.commenterId);
        formData.append("post-id", e.target.dataset.postId);
        formData.append("rel", e.target.dataset.rel);

        const response = await fetch("./src/client/post.php", {
            method: "POST",
            body: formData
        });

        const commentStatsHTML = await response.text();
        
        jQuery(commentStatsSelector).replaceWith(commentStatsHTML);
    }
}

/**
 * Event handler for liking a  post
 * @param {Object} e - the HTML Event object 
 */
async function onClickLikeButton(e) {
    if (e.target.classList.contains("like", "icon")) {
        const likeStatsSelector = `[data-post-stats="${e.target.dataset.postId}"] span[data-like-count]`;
        const formData = new FormData();
        formData.append("post-id", `${e.target.dataset.postId}`);
        formData.append("rel", "like-post");
        formData.append("user-id", `${userIdHiddenInput.value}`);

        const response = await fetch("./src/client/post.php", {
            method: "POST",
            body: formData
        });

        const likeStatsHTML = await response.text();
        jQuery(likeStatsSelector).replaceWith(likeStatsHTML);

        console.log(e.target);
    }
    
}
