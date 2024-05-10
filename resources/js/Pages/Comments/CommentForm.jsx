import React, { useState } from "react";
import { useForm } from "@inertiajs/react";
import InputError from "@/Components/InputError";
import PrimaryButton from "@/Components/PrimaryButton";
import TextArea from "@/Components/TextArea";
import showNotification from "@/Components/showNotification";

const CommentForm = ({ resourceId }) => {
    const { data, setData, post, processing, errors, reset } = useForm({
        content: "",
        resource_id: resourceId,
    });

    const handleSubmit = (e) => {
        e.preventDefault();
        showNotification("success", "Commentaire posté avec succès!");
        setTimeout(() => {
            post(route("comments.store"), data);
            data.content = "";
            setData({ ...data });
        }, 1000);
    };

    return (
        <div className="mt-8 text-center">
            <h2 className="text-2xl font-bold mb-4">Ajouter un commentaire</h2>
            <div className="flex justify-center">
                <div className="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
                    <form onSubmit={handleSubmit}>
                        <input
                            type="hidden"
                            name="resource_id"
                            value={data.resource_id}
                        />

                        <div className="mt-4">
                            <TextArea
                                id="content"
                                name="content"
                                placeholder="Votre commentaire..."
                                value={data.content}
                                className="mt-1 block w-full"
                                autoComplete="content"
                                onChange={(e) =>
                                    setData("content", e.target.value)
                                }
                                requireda
                            />
                            <InputError
                                message={errors.content}
                                className="mt-2"
                            />
                        </div>
                        <div className="flex items-center justify-end mt-4">
                            <PrimaryButton type="submit" disabled={processing}>
                                Ajouter
                            </PrimaryButton>
                        </div>
                    </form>
                </div>
            </div>
            <div className="mt-3">
                Chaque commentaire posté te rapport un point !
            </div>
        </div>
    );
};

export default CommentForm;
