import React from "react";
import { Avatar } from "flowbite-react";
//display les avatar des users inline
function Avatars({ users }) {
    return (
        <div style={{ overflowX: "auto", whiteSpace: "nowrap", textAlign: "center" }}>
            <div
                className="flex"
                style={{
                    justifyContent: "center",
                    gap: ".25rem",
                    padding: ".5rem",
                }}
            >
                {users.map((user, index) => (
                    <div
                        key={index}
                        style={{
                            minWidth: "60px",
                            flexShrink: 0,
                            marginBottom: ".25vh",
                        }}
                    >
                        <div
                            style={{
                                display: "inline-block",
                                border: "2px solid green",
                                borderRadius: "50%",
                                padding: "1px",
                            }}
                        >
                            <Avatar
                                img={user.image}
                                alt={`avatar_${index}`}
                                rounded
                            />
                        </div>
                        <div>{user.name}</div>{" "}
                    </div>
                ))}
            </div>
        </div>
    );
}

export default Avatars;

{/*
function Avatars({ avatarImages }) {
    return (
        <div style={{ overflowX: "auto", whiteSpace: "nowrap" }}>
            <div
                className="flex"
                style={{
                    gap: ".25rem",
                    padding: ".5rem",
                    justifyContent: "flex-start",
                    textAlign: "center",
                }}
            >
                {avatarImages.map((avatar, index) => (
                    <div
                        key={index}
                        style={{
                            minWidth: "60px",
                            flexShrink: 0,
                            marginBottom: ".25vh",
                        }}
                    >
                        <div
                            style={{
                                display: "inline-block",
                                border: "2px solid green",
                                borderRadius: "50%",
                                padding: "1px",
                            }}
                        >
                            <Avatar
                                img={avatar.img}
                                alt={`avatar_${index}`}
                                rounded
                            />
                        </div>
                        <div>{avatar.name}</div>{" "}
                    </div>
                ))}
            </div>
        </div>
    );
}
*/}


